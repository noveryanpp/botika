<?php

namespace App\Http\Controllers\Api;

use App\Models\Division;
use App\Http\Resources\DivisionResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Division::with('positions');

        $divisions = $query->get();

        $divisions->transform(function ($renameDivision) {
            $renameDivision->position_list = $renameDivision->positions;
            unset($renameDivision->positions);

            return $renameDivision;
        });

        $divisions->transform(function ($division) {
            $division->positions = $division->position_list
                ->map(fn($position) => $position->title)
                ->implode(', ');

            unset($division->position_list);
            unset($division->created_at);
            unset($division->updated_at);
    
            return $division;
        });

        return new DivisionResource(true, 'Successfully fetched divisions', $divisions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $division = Division::create($validator->validated());
        return new DivisionResource(true, 'Successfully added division', $division);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $division = Division::find($id);

        return new DivisionResource(true, 'Successfully fetched division', $division);
    }

    public function employees(string $id)
    {
        $division = Division::with('employeeJobs.employee')->find($id);

        return new DivisionResource(true, 'Successfully fetched division\'s employees', $division);
    }

    public function positions(string $id)
    {
        $division = Division::with('positions')->find($id);

        return new DivisionResource(true, 'Successfully fetched division\'s positions', $division);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $division = Division::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $division->update($validator->validated());
        return new DivisionResource(true, 'Successfully updated division', $division);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $division = Division::find($id);

        $division->delete();

        return response()->json([
            'status' => true,
            'message' => 'Successfully deleted division'
        ]);
    }
}
