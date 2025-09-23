<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Paciente extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'pacientes';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'telefone',
        'imagem',
    ];

    public function atividades()
    {
        return $this->hasMany(Atividade::class);
    }

    public function dentistas()
    {
        return $this->belongsToMany(Dentista::class, 'atividades', 'paciente_id', 'dentista_id');
    }
}
