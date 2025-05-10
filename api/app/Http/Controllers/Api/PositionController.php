<?php

namespace App\Http\Controllers\Api;

use App\Models\Position;
use App\Http\Resources\PositionResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::with('division')->get();

        $positions->transform(function ($renameDivision) {
            $renameDivision->division_data = $renameDivision->division;
            unset($renameDivision->division);

            return $renameDivision;
        });

        $positions->transform(function ($position) {
            $position->division = $position->division_data->name ?? null;
            unset($position->division_data, $position->division_id, $position->created_at, $position->updated_at); 
            return $position;
        });
        
        return new PositionResource(true, 'Successfully fetched positions', $positions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'division_id' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        $position = Position::create($validator->validated());

        return new PositionResource(true, 'Successfully added position', $position);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $position = Position::find($id);

        return new PositionResource(true, 'Successfully fetched position', $position);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $position = Position::find($id);

        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'division_id' => 'sometimes|required|int',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        $position->update($validator->validated());

        return new PositionResource(true, 'Successfully updated position', $position);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = Position::find($id);

        $position->delete();
        return response()->json([
            'status'  => true,
            'message' => 'Successfully deleted position',
        ]);
    }
}
