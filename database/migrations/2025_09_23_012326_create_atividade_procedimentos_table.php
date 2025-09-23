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
        Schema::create('atividade_procedimentos', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // mesmo id da atividade
            $table->foreign('id')->references('id')->on('atividades')->onDelete('cascade');

            $table->text('materiais_usados')->nullable();
            $table->integer('duracao_min')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atividade_procedimentos');
    }
};
