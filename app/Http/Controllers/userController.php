<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class userController extends Controller
{


    public function postsUsuario()
    {
        $user = User::with(['posts' => function ($query) {
            $query->where('status', 'publico')
                ->orderBy('created_at', 'desc')
                ->take(5); 
        }])->find(1);

        return response()->json($user);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
