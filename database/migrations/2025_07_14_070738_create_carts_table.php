<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // តភ្ជាប់ទៅអ្នកប្រើ និងផលិតផល
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // បរិមាណទំនិញក្នុង cart
            $table->unsignedInteger('quantity')->default(1);

            // តម្លៃ snapshot ពេលដាក់ cart (បើ admin ប្តូរតម្លៃក្រោយមក total មិនប្រែ)
            $table->decimal('price_snapshot', 10, 2)->nullable();

            // ទិន្នន័យបន្ថែមដូចជា color, size (ជាជម្រើស)
            $table->json('options')->nullable();

            $table->timestamps();

            // បង្ការការដាក់ផលិតផលដូចគ្នាពីរ ដល់ cart user ម្នាក់
            $table->unique(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
