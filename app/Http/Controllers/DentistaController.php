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
    public function update(Request $request)
    {
        $dentista = Auth::user();

        if (!$dentista instanceof Dentista) {
            return response()->json(['message' => 'Acesso não autorizado ou usuário inválido.'], 403);
        }

        try {
            $validatedData = $request->validate([
                'nome' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255',
                'data_nascimento' => 'sometimes|required|date_format:Y-m-d',
            ]);
            
            $dentista->update($validatedData);

            return response()->json([
                'message' => 'Perfil atualizado com sucesso!',
                'dentista' => $dentista
            ]);

        } catch (ValidationException $e) {
            return response()->json(['message' => 'Dados inválidos.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar dentista ID ' . $dentista->id . ': ' . $e->getMessage());

            return response()->json(['message' => 'Ocorreu um erro interno ao tentar atualizar o perfil.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request) 
    {
        $dentista = Auth::user();

        if (!$dentista instanceof Dentista) {
            return response()->json(['message' => 'Nenhum usuário autenticado encontrado.'], 401);
        }

        try {
            $dentista->delete();
            $dentista->tokens()->delete();

            return response()->json(['message' => 'Perfil excluído com sucesso.'], 200);

        } catch (\Exception $e) {
            Log::error('Erro ao deletar dentista ID ' . $dentista->id . ': ' . $e->getMessage());
            return response()->json(['message' => 'Ocorreu um erro interno ao tentar excluir o perfil.'], 500);
        }
    }
}
