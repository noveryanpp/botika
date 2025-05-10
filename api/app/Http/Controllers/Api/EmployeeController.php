<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::with(['employeeJobs.position', 'employeeJobs.division']);

        if ($request->has('status')) {
            $status = $request->status;
            if (in_array($status, ['active', 'inactive'])) {
                $query->where('status', $status);
            }
        }

        $employees = $query->get();

        $employees->transform(function ($employee) {
            $employee->positions = $employee->employeeJobs
                ->map(fn($job) => $job->position->title)
                ->implode(', ');
            $employee->divisions = $employee->employeeJobs
                ->map(fn($job) => $job->division->name)->unique()
                ->implode(', ');

            unset($employee->employeeJobs);
            unset($employee->created_at);
            unset($employee->updated_at);
    
            return $employee;
        });

        return new EmployeeResource(true, 'Successfully fetched employees', $employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'email'  => 'required|email',
            'phone'  => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $employee = Employee::create($validator->validated());
        return new EmployeeResource(true, 'Successfully added employee', $employee);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::find($id);

        $employee->load(['employeeJobs.position', 'employeeJobs.division']);
        return new EmployeeResource(true, 'Successfully fetched employee', $employee);
    }

    public function active()
    {
        $employees = Employee::with(['employeeJobs.position', 'employeeJobs.division', 'files'])
            ->where('status', 'active')
            ->get();

        return new EmployeeResource(true, 'Successfully fetched active employees', $employees);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::find($id);

        $validator = Validator::make($request->all(), [
            'name'   => 'sometimes|required|string|max:255',
            'email'  => 'sometimes|required|email',
            'phone'  => 'sometimes|required|string|max:20',
            'status' => 'sometimes|required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $employee->update($validator->validated());
        return new EmployeeResource(true, 'Successfully updated employee', $employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);

        $employee->delete();
        return response()->json([
            'status' => true,
            'message' => 'Successfully deleted employee'
        ]);
    }
}
