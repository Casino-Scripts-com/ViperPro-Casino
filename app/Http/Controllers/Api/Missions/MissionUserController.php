<?php

namespace App\Http\Controllers\Api\Missions;

use App\Http\Controllers\Controller;
use App\Models\MissionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MissionUserController extends Controller
{
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
        $rules = [
            'mission_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $createData = MissionUser::create([
            'user_id' => auth('api')->id(),
            'mission_id' => $request->mission_id
        ]);

        if($createData) {
            return response()->json(['status' => true, 'message' => '']);
        }

        return response()->json(['status' => false, 'error' => '']);
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
