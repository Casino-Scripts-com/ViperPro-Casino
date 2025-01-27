<?php

namespace App\Http\Controllers\Api\Missions;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $period = request('period', 'daily'); // Obtenha o valor do parâmetro 'period', padrão é 'daily'
        $today = Carbon::now()->toDateString();

        $missions = Mission::when($period === 'daily', function ($query) use ($today) {
                return $query->whereDate('challenge_start_date', '<=', $today)
                    ->whereDate('challenge_end_date', '>=', $today);
            })
            ->when($period === 'week', function ($query) use ($today) {
                $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
                $endOfWeek = Carbon::now()->endOfWeek()->toDateString();

                return $query->whereDate('challenge_start_date', '<=', $endOfWeek)
                    ->whereDate('challenge_end_date', '>=', $startOfWeek);
            })
            ->get();

        return response()->json(['missions' => $missions]);
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
