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
        Schema::table('resellers', function (Blueprint $table) {
            $table->after('password', function (Blueprint $table) {
                $table->integer('inside_dhaka')->default(70);
                $table->integer('outside_dhaka')->default(130);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resellers', function (Blueprint $table) {
            $table->dropColumn(['inside_dhaka', 'outside_dhaka']);
        });
    }
};
