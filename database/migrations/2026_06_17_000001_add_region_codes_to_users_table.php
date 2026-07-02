<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'province_code')) {
                $table->string('province_code')->nullable()->after('province');
            }
            if (!Schema::hasColumn('users', 'city_code')) {
                $table->string('city_code')->nullable()->after('city');
            }
            if (!Schema::hasColumn('users', 'district_code')) {
                $table->string('district_code')->nullable()->after('district');
            }
            if (!Schema::hasColumn('users', 'village_code')) {
                $table->string('village_code')->nullable()->after('village');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['province_code', 'city_code', 'district_code', 'village_code']);
        });
    }
};
