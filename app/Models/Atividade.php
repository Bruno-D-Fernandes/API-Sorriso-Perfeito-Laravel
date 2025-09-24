<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AtividadeConsulta;
use App\Models\AtividadeExame;
use App\Models\AtividadeProcedimento;

class Atividade extends Model
{
    protected $table = 'atividades';
    protected $fillable = ['paciente_id', 'data', 'hora', 'status' ,'descricao', 'valor'];

    // public function tipo()
    // {
    //     return $this->belongsTo(TipoAtividade::class, 'tipo_atividade_id');
    // } por enquanto está com enum

    public function dentista()
    {
        return $this->belongsTo(Dentista::class);
    }

    public function paciente(){
        return $this->belongsTo(Paciente::class); // Verificar isso
    }

    public function consulta()
    {
        return $this->hasOne(AtividadeConsulta::class, 'id');
    }

    public function exame()
    {
        return $this->hasOne(AtividadeExame::class, 'id');
    }

    public function procedimento()
    {
        return $this->hasOne(AtividadeProcedimento::class, 'id');
    }

}
