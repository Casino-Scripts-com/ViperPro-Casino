<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeUser(User $user)
    {

        // Verifica se o usuário autenticado já deu like no usuário fornecido
        if (auth('api')->user()->likes()->where('liked_user_id', $user->id)->exists()) {
            $like = auth('api')->user()->likes()->where('liked_user_id', $user->id)->first();
            $like->delete();
        }else{
            // Cria um novo like para o usuário fornecido
            $like = new Like();
            $like->user_id = auth('api')->user()->id;
            $like->liked_user_id = $user->id;
            $like->save();
        }

        return response()->json(['message' => trans('Like added successfully.')]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
