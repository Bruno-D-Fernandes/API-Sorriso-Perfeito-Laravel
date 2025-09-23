<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeProcedimento extends Model
{
    use HasFactory;

    protected $table = 'atividade_procedimentos';
    protected $fillable = ['id', 'materiais_usados', 'duracao_min'];
    public $incrementing = false; // porque PK é o mesmo id da Atividade

    public function atividade()
    {
        return $this->belongsTo(Atividade::class, 'id');
    }
}
