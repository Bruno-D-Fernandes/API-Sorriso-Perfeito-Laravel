<?php

namespace App\Http\Controllers;

use App\Models\Dentista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DentistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dentistas = Dentista::all(); // Provavelmente n˜ão vou usar isso 
        return response()->json($dentistas);
    }

    /**
     * Handles user login and token generation.
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'senha' => 'required',
            ]);

            $dentista = Dentista::where('email', $credentials['email'])->first();

            if (!$dentista || !Hash::check($credentials['senha'], $dentista->senha)) {
                throw ValidationException::withMessages([
                    'email' => ['As credenciais fornecidas estão incorretas.'],
                ]);
            }

            $token = $dentista->createToken('auth-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'dentista' => $dentista // Retorna o objeto dentista junto com o token
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Logout
     */

    public function logout(Request $request)
    {
        try {
            // Revoga apenas o token usado nessa requisição
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout realizado com sucesso.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao realizar logout.',
                'message' => $e->getMessage()
            ], 500);
        }
    }


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
            $token = $dentista->createToken('auth-token')->plainTextToken;


            return response()->json([
                'token' => $token,
                'dentista' => $dentista
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Não foi possível criar o dentista. Tente novamente mais tarde.', 'log' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function me(Request $request)
    {
        $user = $request->user();
        $dentista = Dentista::findOrFail($user->id);
        return response()->json($dentista);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dentista $dentista)
    {
        // Protege a rota
        if (Auth::guard('sanctum')->id() !== $dentista->id) {
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
        }

        try {
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:dentistas,email,' . $dentista->id,
                'data_nascimento' => 'required|date',
            ]);

            $dentista->update($validatedData);

            return response()->json([
                'dentista' => $dentista
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar dentista: ' . $e->getMessage());
            return response()->json(['error' => 'Não foi possível atualizar o dentista.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dentista $dentista)
    {
        // Protege a rota
        if (Auth::guard('sanctum')->id() !== $dentista->id) {
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
        }

        try {
            $dentista->delete();
            return response()->json(['message' => 'Dentista excluído com sucesso.'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar dentista: ' . $e->getMessage());
            return response()->json(['error' => 'Não foi possível excluir o dentista.'], 500);
        }
    }
}
