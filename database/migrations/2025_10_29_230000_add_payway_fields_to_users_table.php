<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'payway_account')) {
                $table->string('payway_account')->nullable()->after('profile_photo');
            }
            if (!Schema::hasColumn('users', 'enable_qr')) {
                $table->boolean('enable_qr')->default(false)->after('payway_account');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'enable_qr')) {
                $table->dropColumn('enable_qr');
            }
            if (Schema::hasColumn('users', 'payway_account')) {
                $table->dropColumn('payway_account');
            }
        });
    }
};
