<?php

namespace App\Http\Controllers;

use App\Models\Dentista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DentistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    // public function login(Request $resquest){ // Finalizar parte do login.
    //     $credentials = $resquest->validate([
    //         'email' => 'required|string|',
    //         'senha' => 'required|min:3',
    //     ])

    //     if(Auth::attempt($credentials)){
    //         @
    //     }

    // }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request) // Cadastro do dentista
    {
        try {
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:dentistas',
                'senha' => 'required|string|min:3',
                'data_nascimento' => 'required|date',
            ]);

            $validatedData['senha'] = Hash::make($validatedData['senha']);
            $dentista = Dentista::create($validatedData);

            return response()->json($dentista, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar dentista: ' . $e->getMessage());
            return response()->json(['error' => 'Não foi possível criar o dentista.'], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Dentista $dentista)
    {
        // try{ // Terminar depois para o dentista ver o perfil
        // Dentista::query()


        // } catch (\Exception $e){

        // }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dentista $dentista)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dentista $dentista)
    {
        //
    }
}
