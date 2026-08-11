<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ShippingCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_fails_without_shipping_address(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(stock: 5);
        $this->createCartItem(user: $user, product: $product, qty: 1);

        $response = $this
            ->actingAs($user)
            ->from('/checkout')
            ->post('/checkout');

        $response
            ->assertRedirect('/checkout')
            ->assertSessionHasErrors([
                'recipient_name',
                'recipient_phone',
                'address_line',
                'province',
                'city',
                'district',
                'postal_code',
            ]);

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_checkout_stores_shipping_snapshot_and_uses_grand_total_for_midtrans(): void
    {
        config(['shipping.placeholder_cost' => 15000]);

        $user = User::factory()->create(['name' => 'Original User']);
        $product = $this->createProduct(stock: 5, price: 129000);
        $this->createCartItem(user: $user, product: $product, qty: 2);

        $expectedSubtotal = 258000;
        $expectedShippingCost = 15000;
        $expectedGrandTotal = 273000;

        Mockery::mock('alias:Midtrans\Snap')
            ->shouldReceive('getSnapToken')
            ->once()
            ->withArgs(function (array $params) use ($expectedGrandTotal, $expectedShippingCost) {
                $this->assertSame($expectedGrandTotal, (int) $params['transaction_details']['gross_amount']);
                $this->assertSame('Rani Customer', $params['customer_details']['shipping_address']['first_name']);
                $this->assertSame('081234567890', $params['customer_details']['shipping_address']['phone']);

                $shippingItem = collect($params['item_details'])
                    ->firstWhere('id', 'SHIPPING');

                $this->assertNotNull($shippingItem);
                $this->assertSame($expectedShippingCost, $shippingItem['price']);
                $this->assertSame(1, $shippingItem['quantity']);

                $itemTotal = collect($params['item_details'])->sum(
                    fn ($item) => $item['price'] * $item['quantity']
                );

                $this->assertSame($expectedGrandTotal, $itemTotal);

                return true;
            })
            ->andReturn('test-snap-token');

        $response = $this
            ->actingAs($user)
            ->post('/checkout', $this->validShippingAddress());

        $transaction = Transaction::firstOrFail();

        $response->assertRedirect('/payments/' . $transaction->id);

        $this->assertSame('Rani Customer', $transaction->recipient_name);
        $this->assertSame('081234567890', $transaction->recipient_phone);
        $this->assertSame('Jl. Melati No. 15', $transaction->address_line);
        $this->assertSame('Jawa Barat', $transaction->province);
        $this->assertSame('Bandung', $transaction->city);
        $this->assertSame('Coblong', $transaction->district);
        $this->assertSame('40132', $transaction->postal_code);
        $this->assertSame('15000.00', $transaction->shipping_cost);
        $this->assertSame('258000.00', $transaction->subtotal);
        $this->assertSame('273000.00', $transaction->grand_total);
        $this->assertSame('test-snap-token', $transaction->snap_token);
        $this->assertDatabaseCount('transaction_items', 1);
        $this->assertDatabaseCount('cart_items', 0);

        $user->update(['name' => 'Updated User']);

        $this->assertSame('Rani Customer', $transaction->refresh()->recipient_name);
    }

    private function createProduct(int $stock, int $price = 129000): Product
    {
        $category = Category::create([
            'name' => 'Skincare',
            'slug' => 'skincare-' . uniqid(),
            'description' => 'Skincare category',
            'is_active' => true,
        ]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Glow Serum ' . uniqid(),
            'slug' => 'glow-serum-' . uniqid(),
            'short_description' => 'Daily glow serum',
            'description' => 'Daily glow serum for testing.',
            'price' => $price,
            'discount_price' => null,
            'stock' => $stock,
            'sku' => 'SKU-' . uniqid(),
            'thumbnail' => null,
            'is_active' => true,
            'is_featured' => true,
            'meta_title' => 'Glow Serum',
            'meta_description' => 'Glow Serum',
        ]);
    }

    private function createCartItem(User $user, Product $product, int $qty): CartItem
    {
        $cart = Cart::create(['user_id' => $user->id]);

        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'qty' => $qty,
            'price' => $product->price,
            'subtotal' => $product->price * $qty,
        ]);
    }

    private function validShippingAddress(array $overrides = []): array
    {
        return array_merge([
            'recipient_name' => 'Rani Customer',
            'recipient_phone' => '081234567890',
            'address_line' => 'Jl. Melati No. 15',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40132',
            'shipping_cost' => 15000,
        ], $overrides);
    }
}
