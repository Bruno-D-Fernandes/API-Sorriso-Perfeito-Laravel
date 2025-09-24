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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dentista_id')->references('id')->on('dentistas')->onDelete('cascade');
            $table->string('nome');
            $table->date('data_nascimento');
            $table->string('telefone')->nullable(); // aqui pode ter um link para o whatsapp futuramente
            $table->text('Imagem')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
