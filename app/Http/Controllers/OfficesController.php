<?php

namespace App\Http\Controllers;

use App\Models\Offices;

class OfficesController extends Controller
{
    public function fetchAllOffices()
    {
        // Fetch all offices
        $offices = Offices::all();

        // Return the offices as a JSON response
        return response()->json($offices, 200);
    }
    public function fetchDivisions()
    {
        // Fetch all offices without division
        $offices = Offices::whereNull('division_id')->get();

        // Return the offices as a JSON response
        return response()->json($offices, 200);
    }
    public function fetchOfficesByDivision($division_id)
    {
        if (!is_numeric($division_id)) {
            return response()->json(['error' => 'Invalid division ID'], 400);
        }
        // Fetch all offices by division and its sub-offices
        $offices = Offices::where('division_id', $division_id)->get();
        // fetch sub-offices
        foreach ($offices as $office) {
            $subOffices = Offices::where('division_id', $office->id)->get();
            $offices = $offices->merge($subOffices);
        }

        // Return the offices as a JSON response
        return response()->json($offices, 200);
    }

}
