<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ បន្ថែម FULLTEXT index
        DB::statement('ALTER TABLE products ADD FULLTEXT ft_title_desc (title, description)');
    }

    public function down(): void
    {
        // 🧹 លុបចោល index ពេល rollback
        DB::statement('ALTER TABLE products DROP INDEX ft_title_desc');
    }
};
