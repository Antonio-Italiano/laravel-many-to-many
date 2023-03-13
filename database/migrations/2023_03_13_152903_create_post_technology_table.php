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
        Schema::create('project_technology', function (Blueprint $table) {
            $table->id();

            //metto le colonne
            // $table->unsignedBigInteger('project_id');
            // $table->unsignedBigInteger('technology_id');

            //assegno la relazione
            // $table->foreign('project_id')->references('id')->on('projects');
            // $table->foreign('technology_id')->references('id')->on('technologies');

            // Versione compressa
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('technology_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_technology');
    }
};
