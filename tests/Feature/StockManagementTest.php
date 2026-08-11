<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_is_rejected_when_cart_qty_exceeds_stock(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(stock: 1);
        $cart = Cart::create(['user_id' => $user->id]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'qty' => 2,
            'price' => $product->price,
            'subtotal' => $product->price * 2,
        ]);

        $response = $this
            ->actingAs($user)
            ->from('/cart')
            ->post('/checkout');

        $response
            ->assertRedirect('/cart')
            ->assertSessionHas('error');

        $this->assertDatabaseCount('transactions', 0);
        $this->assertSame(1, $product->refresh()->stock);
    }

    public function test_payment_settlement_reduces_product_stock(): void
    {
        $product = $this->createProduct(stock: 5);
        $transaction = $this->createPendingTransaction(product: $product, qty: 2);

        $response = $this->postJson(
            '/midtrans/callback',
            $this->signedMidtransPayload($transaction)
        );

        $response
            ->assertOk()
            ->assertJson(['message' => 'Callback success']);

        $this->assertSame(3, $product->refresh()->stock);
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'payment_status' => 'paid',
            'transaction_status' => 'processing',
            'payment_method' => 'bank_transfer',
        ]);
        $this->assertNotNull($transaction->refresh()->paid_at);
    }

    public function test_duplicate_settlement_callback_does_not_reduce_stock_twice(): void
    {
        $product = $this->createProduct(stock: 5);
        $transaction = $this->createPendingTransaction(product: $product, qty: 2);
        $payload = $this->signedMidtransPayload($transaction);

        $this->postJson('/midtrans/callback', $payload)->assertOk();
        $this->postJson('/midtrans/callback', $payload)->assertOk();

        $this->assertSame(3, $product->refresh()->stock);
    }

    public function test_settlement_does_not_make_product_stock_negative(): void
    {
        $product = $this->createProduct(stock: 1);
        $transaction = $this->createPendingTransaction(product: $product, qty: 2);

        $response = $this->postJson(
            '/midtrans/callback',
            $this->signedMidtransPayload($transaction)
        );

        $response
            ->assertStatus(409)
            ->assertJson(['message' => 'Insufficient stock for settlement']);

        $this->assertSame(1, $product->refresh()->stock);
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'payment_status' => 'pending',
            'transaction_status' => 'pending',
        ]);
    }

    public function test_out_of_stock_product_cannot_be_added_to_cart(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(stock: 0);

        $response = $this
            ->actingAs($user)
            ->from('/products/' . $product->slug)
            ->post('/cart/add/' . $product->id);

        $response
            ->assertRedirect('/products/' . $product->slug)
            ->assertSessionHas('error');

        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_cart_qty_update_cannot_exceed_current_stock(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(stock: 2);
        $cart = Cart::create(['user_id' => $user->id]);
        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'qty' => 1,
            'price' => $product->price,
            'subtotal' => $product->price,
        ]);

        $response = $this
            ->actingAs($user)
            ->from('/cart')
            ->post('/cart/update/' . $cartItem->id, [
                'qty' => 3,
            ]);

        $response
            ->assertRedirect('/cart')
            ->assertSessionHas('error');

        $this->assertSame(1, $cartItem->refresh()->qty);
    }

    private function createProduct(int $stock): Product
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
            'price' => 129000,
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

    private function createPendingTransaction(Product $product, int $qty): Transaction
    {
        $user = User::factory()->create();
        $total = $product->price * $qty;

        $transaction = Transaction::create([
            'invoice_number' => 'INV-' . uniqid(),
            'user_id' => $user->id,
            'subtotal' => $total,
            'grand_total' => $total,
            'payment_status' => 'pending',
            'transaction_status' => 'pending',
            'payment_method' => 'midtrans',
        ]);

        TransactionItem::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'qty' => $qty,
            'price' => $product->price,
            'subtotal' => $total,
        ]);

        return $transaction;
    }

    private function signedMidtransPayload(Transaction $transaction): array
    {
        config(['midtrans.server_key' => 'test-server-key']);

        $grossAmount = number_format((float) $transaction->grand_total, 2, '.', '');

        $payload = [
            'order_id' => $transaction->invoice_number,
            'status_code' => '200',
            'gross_amount' => $grossAmount,
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
        ];

        $payload['signature_key'] = hash(
            'sha512',
            $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . config('midtrans.server_key')
        );

        return $payload;
    }
}
