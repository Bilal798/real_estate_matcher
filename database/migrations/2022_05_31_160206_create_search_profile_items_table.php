<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_profile_items', function (Blueprint $table) {
            $table->id();
            $table->json('price');
            $table->json('area');
            $table->json('yearOfConstruction');
            $table->json('rooms');
            $table->integer('searchProfileId');
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
        Schema::dropIfExists('search_profile_items');
    }
};
