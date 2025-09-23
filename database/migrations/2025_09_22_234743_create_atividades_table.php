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
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dentista_id')->references('id')->on('dentistas')->onDelete('cascade');
            $table->foreignId('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            // $table->foreignId('tipo_atividade_id')->references('id')->on('tipo_atividades')->onDelete('cascade');
            $table->date('data');
            $table->time('hora');
            $
            $table->enum('status', ['agendada', 'concluida', 'cancelada', 'atrasada'])->default('agendada');
            $table->text('descricao')->nullable();
            $table->decimal('valor', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atividades');
    }
};
