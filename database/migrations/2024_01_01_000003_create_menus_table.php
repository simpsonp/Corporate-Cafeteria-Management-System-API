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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->date('menu_date');
            $table->unsignedBigInteger('meal_type_id');
            $table->string('item_name');
            $table->timestamps();
            $table->foreign('meal_type_id')->references('id')->on('meal_types');
            $table->unique(['menu_date', 'meal_type_id']);
            $table->comment('Menu items available for each meal type on each day of the week');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
