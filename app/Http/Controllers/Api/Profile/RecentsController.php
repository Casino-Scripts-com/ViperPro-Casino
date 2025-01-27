<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Order;
use Illuminate\Http\Request;

class RecentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gamesPlayed = Order::where('user_id', auth('api')->id())->groupBy('game_uuid')->pluck('game_uuid');
        $games = Game::whereIn('game_id', $gamesPlayed)->get();
        if(count($games) > 0) {
            return response()->json(['games' => $games]);
        }

        return response()->json([], 400);
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
