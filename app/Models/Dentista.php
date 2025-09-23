<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dentista extends Model
{
    use HasFactory;

    protected $table = 'dentistas';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'data_nascimento',
    ];

    public function atividades()
    {
        return $this->hasMany(Atividade::class);
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
