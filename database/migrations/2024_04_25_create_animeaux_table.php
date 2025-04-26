<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('animeaux', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('type'); // mammifère, oiseau, reptile, etc.
            $table->string('espece');
            $table->text('description');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('animeaux');
    }
}; 