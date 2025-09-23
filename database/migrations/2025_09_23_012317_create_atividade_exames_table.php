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
        Schema::create('atividade_exames', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // mesmo id da atividade
            $table->foreign('id')->references('id')->on('atividades')->onDelete('cascade');

            $table->text('resultado')->nullable();
            $table->string('laboratorio', 100)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atividade_exames');
    }
};
