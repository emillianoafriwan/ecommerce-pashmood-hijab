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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'admin_read')) {
                $table->boolean('admin_read')->default(false)->after('cancellation_reason');
            }
        });

        // Mark all existing orders as read so they don't flood notifications
        \DB::table('orders')->update(['admin_read' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'admin_read')) {
                $table->dropColumn('admin_read');
            }
        });
    }
};
