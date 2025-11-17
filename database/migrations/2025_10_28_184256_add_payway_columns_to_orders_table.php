<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // បន្ថែមកូឡុំ ABA
            if (!Schema::hasColumn('orders', 'tran_id')) {
                $table->string('tran_id', 191)->unique()->after('phone')->nullable();
            }
            if (!Schema::hasColumn('orders', 'amount')) {
                $table->decimal('amount', 12, 2)->after('tran_id')->default(0);
            }
            if (!Schema::hasColumn('orders', 'currency')) {
                $table->string('currency', 10)->after('amount')->default('USD');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status', 50)->after('currency')->default('pending');
            }
            if (!Schema::hasColumn('orders', 'meta')) {
                // MySQL 5.7+ គាំទ្រ JSON; ប្រសិនបើ <5.7 សូមប្ដូរ->text()
                $table->json('meta')->nullable()->after('status');
            }

            // ប្រាកដថា product_id អាច NULL និង on delete set null (ស្រេចចិត្ត)
            // NOTE: បើ FK មានរួច អាចរំលង
            // $table->unsignedBigInteger('product_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'tran_id'))        $table->dropUnique(['tran_id']);
            $table->dropColumn(['tran_id', 'amount', 'currency', 'payment_status', 'meta']);
        });
    }
};
