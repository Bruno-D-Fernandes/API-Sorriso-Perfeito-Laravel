<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtividadeConsulta extends Model
{
    protected $table = 'atividade_consultas';
    protected $fillable = ['id', 'diagnostico', 'retorno'];
    public $incrementing = false; // porque PK é o mesmo id da Atividade

    public function atividade()
    {
        return $this->belongsTo(Atividade::class, 'id');
    }
}
