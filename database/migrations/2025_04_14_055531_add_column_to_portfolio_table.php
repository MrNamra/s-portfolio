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
        Schema::table('portfolio', function (Blueprint $table) {
            $table->integer('display_order')->after('info')->default(0)->index();
            $table->longText('info')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolio', function (Blueprint $table) {
            $table->drop('display_order');
        });
    }
};
