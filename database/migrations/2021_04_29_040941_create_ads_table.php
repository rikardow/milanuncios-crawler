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
            $table->integer('price')->nullable();
            $table->text('description');
            $table->integer('reference');
            $table->integer('views')->default(0);
            $table->string('publisher_name', 60)->nullable();
            $table->string('location', 60)->nullable();
            $table->text('image')->nullable();
            $table->json('tags');
            $table->boolean('free_shipping');
            $table->foreignId('category_id')->references('id')->on('ad_categories')->restrictOnDelete();
            $table->string('url', 160);
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
