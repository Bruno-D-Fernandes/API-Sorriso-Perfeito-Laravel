<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeExame extends Model
{
    use HasFactory;

    protected $table = 'atividade_exames';
    protected $fillable = ['id', 'resultado', 'laboratorio'];
    public $incrementing = false; // porque PK é o mesmo id da Atividade

    public function atividade()
    {
        return $this->belongsTo(Atividade::class, 'id');
    }
}
