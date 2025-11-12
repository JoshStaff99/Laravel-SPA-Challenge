<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the movie migrations.
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('director')->nullable();
            $table->date('release_date')->nullable();
            $table->integer('duration')->nullable(); // in minutes
            $table->timestamps();
        });
    }


    /**
     * Reverse the movie migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
