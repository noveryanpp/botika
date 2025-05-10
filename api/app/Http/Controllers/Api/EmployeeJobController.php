<?php

namespace App\Http\Controllers\Api;

use App\Models\EmployeeJob;
use App\Http\Resources\EmployeeJobResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = EmployeeJob::with(['employee', 'position', 'division'])->get();
        return new EmployeeJobResource(true, 'Successfully fetched employee jobs', $jobs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'position_id' => 'required|exists:positions,id',
            'division_id' => 'required|exists:divisions,id',
            'salary'      => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $job = EmployeeJob::create($validator->validated());
        $job->load(['employee', 'position', 'division']);

        return new EmployeeJobResource(true, 'Successfully added employee job', $job);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employeeJob = EmployeeJob::find($id);

        $employeeJob->load(['employee', 'position', 'division']);
        return new EmployeeJobResource(true, 'Successfully fetched employee job', $employeeJob);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employeeJob = EmployeeJob::find($id);

        $validator = Validator::make($request->all(), [
            'employee_id' => 'sometimes|required|exists:employees,id',
            'position_id' => 'sometimes|required|exists:positions,id',
            'division_id' => 'sometimes|required|exists:divisions,id',
            'salary'      => 'sometimes|required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $employeeJob->update($validator->validated());
        $employeeJob->load(['employee', 'position', 'division']);

        return new EmployeeJobResource(true, 'Successfully updated employee job', $employeeJob);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employeeJob = EmployeeJob::find($id);

        $employeeJob->delete();
        return response()->json([
            'status' => true,
            'message' => 'Successfully deleted employee job'
        ]);
    }
}
