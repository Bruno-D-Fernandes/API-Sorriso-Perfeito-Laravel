<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // Importar a trait
use Laravel\Sanctum\HasApiTokens; // Importar a trait

class Dentista extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'dentistas';

    protected $fillable = [
        'nome',
        'email',
        'data_nascimento',
    ];

    protected $hidden = [
        'senha',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function atividade()
    {
        return $this->hasMany(Atividade::class);
    }


    public function pacinete(){
        return $this->hasMany(Paciente::class);
    }
}