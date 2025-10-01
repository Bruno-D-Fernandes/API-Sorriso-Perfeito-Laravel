<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePacienteRequest; // Importa nossa classe de validação
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PacienteController extends Controller
{
    /**
     * Lista todos os pacientes pertencentes ao dentista autenticado.
     */
    public function index()
    {
        $pacientes = Auth::user()->pacientes()->orderBy('nome')->get();

        return response()->json($pacientes);
    }

    /**
     * Armazena um novo paciente no banco de dados, associado ao dentista autenticado.
     */
    public function store($request)
    {
        $validatedData = $request->validated();

        // Associa o paciente ao dentista logado antes de criar
        $paciente = Auth::user()->pacientes()->create($validatedData);

        return response()->json([
            'message' => 'Paciente cadastrado com sucesso!',
            'paciente' => $paciente
        ], 201); 
    }

    /**
     * Exibe os detalhes de um paciente específico.
     */
    public function show(Paciente $paciente)
    {
        if (Auth::id() !== $paciente->dentista_id) {
            return response()->json(['message' => 'Acesso não autorizado.'], 403);
        }

        return response()->json($paciente);
    }

    /**
     * Atualiza os dados de um paciente específico.
     */
    public function update(StorePacienteRequest $request, Paciente $paciente)
    {
        // Garante que o dentista só possa atualizar seu próprio paciente
        if (Auth::id() !== $paciente->dentista_id) {
            return response()->json(['message' => 'Acesso não autorizado.'], 403);
        }
    }

}
