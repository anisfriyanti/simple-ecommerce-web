<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('recipient_name')->nullable()->after('user_id');
            $table->string('recipient_phone')->nullable()->after('recipient_name');
            $table->text('address_line')->nullable()->after('recipient_phone');
            $table->string('province')->nullable()->after('address_line');
            $table->string('city')->nullable()->after('province');
            $table->string('district')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('district');
            $table->string('courier')->nullable()->after('payment_method');
            $table->string('shipping_service')->nullable()->after('courier');
            $table->decimal('shipping_cost', 12, 2)->default(0)->after('shipping_service');
            $table->string('shipping_etd')->nullable()->after('shipping_cost');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'recipient_name',
                'recipient_phone',
                'address_line',
                'province',
                'city',
                'district',
                'postal_code',
                'courier',
                'shipping_service',
                'shipping_cost',
                'shipping_etd',
            ]);
        });
    }
};
