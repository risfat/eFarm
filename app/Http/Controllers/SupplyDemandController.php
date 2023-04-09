<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\SupplyDemand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupplyDemandController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'supply_demand' => 'required|string|max:255',
        ]);

        $supply_demand = SupplyDemand::updateOrCreate(
        [
            'user_id' => $user->id
        ],
        [
            'user_id' => $user->id,
            'supply_demand' => $request->supply_demand,
        ]);

        $supply_demand->save();

        return response()->json([
            'message' => 'Successfully Added.',
        ], Response::HTTP_OK);

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();

        return $user->supplyDemand();
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request)
    // {
    //     $user = Auth::user();

    //     $request->validate([
    //         'supply_demand' => 'required|string|max:255',
    //     ]);

    //     $supply_demand = SupplyDemand::where('user_id', $user->id)->first();
    //     $supply_demand = $request->supply_demand;
    //     $supply_demand->save();

    //     return response()->json([
    //         'message' => 'Successfully Added.',
    //     ], Response::HTTP_OK);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplyDemand $supplyDemand)
    {
        //
    }
}
