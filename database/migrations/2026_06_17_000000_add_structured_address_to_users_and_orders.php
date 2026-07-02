<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom alamat terstruktur ke tabel users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'province')) {
                $table->string('province')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('province');
            }
            if (!Schema::hasColumn('users', 'district')) {
                $table->string('district')->nullable()->after('city');
            }
            if (!Schema::hasColumn('users', 'village')) {
                $table->string('village')->nullable()->after('district');
            }
            if (!Schema::hasColumn('users', 'detail_address')) {
                $table->text('detail_address')->nullable()->after('village');
            }
        });

        // Tambah kolom alamat terstruktur ke tabel orders
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'province')) {
                $table->string('province')->nullable()->after('address');
            }
            if (!Schema::hasColumn('orders', 'city')) {
                $table->string('city')->nullable()->after('province');
            }
            if (!Schema::hasColumn('orders', 'district')) {
                $table->string('district')->nullable()->after('city');
            }
            if (!Schema::hasColumn('orders', 'village')) {
                $table->string('village')->nullable()->after('district');
            }
            if (!Schema::hasColumn('orders', 'detail_address')) {
                $table->text('detail_address')->nullable()->after('village');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['province', 'city', 'district', 'village', 'detail_address']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['province', 'city', 'district', 'village', 'detail_address']);
        });
    }
};
