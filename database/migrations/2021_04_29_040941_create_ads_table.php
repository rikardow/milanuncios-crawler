<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('price');
            $table->text('description');
            $table->integer('views')->default(0);
            $table->string('publisher_name');
            $table->boolean('free_shipping');
            $table->foreignId('subcategory_id')->references('id')->on('ad_subcategories')->restrictOnDelete();
            $table->foreignId('province_id')->references('id')->on('communities')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
