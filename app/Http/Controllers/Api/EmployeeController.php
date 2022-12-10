<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Services\EmployeeService;
use App\Http\Controllers\ApiController;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\Api\StoreEmployeeRequest;

class EmployeeController extends ApiController
{
    /**
     * @var EmployeeService
     */
    protected $employeeService;

    /**
     * Employee Service Constructor.
     *
     * @param EmployeeService $employeeService
     */
    public function __construct(EmployeeService $employeeService) 
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Get All Employees.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() 
    {
        try {
            return $this->successResponse(
                    EmployeeResource::collection($this->employeeService->getAllEmployees()), 
                    'Get List of all Employees with their Contact Information.'
                );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Create New Employee.
     *
     * @param  \App\Http\Requests\Api\StoreEmployeeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreEmployeeRequest $request) 
    {
        try {
            $data = $request->only(['name', 'email', 'password', 'type', 'address', 'phone', 'job_title', 'job_description']);
            return $this->successResponse(
                new EmployeeResource($this->employeeService->createEmployee($data)), 
                'Create new Employee with his Contact Information.', 
                201
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Deactivate Employee.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate(User $user) 
    {
        try {
            $this->employeeService->deactivateEmployee($user);
            return $this->successResponse(null, 'Employee deactivated successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
