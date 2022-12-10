<?php

namespace App\Services;

use Exception;
use App\Models\User;

class EmployeeService
{
    CONST EMPLOYEE = 'employee';

    /**
     * Get All Employees.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllEmployees() 
    {
        try {
            return User::with('contact_information')->type(self::EMPLOYEE)->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Create New Employee.
     *
     * @param array $record
     *
     * @return App\Models\User
     */
    public function createEmployee($record)
    {
        try {
            $user = User::create(array_merge(
                $record,
                ['password' => bcrypt($record['password'])]
            ));
            $user->contact_information()->create([
                'address' => $record['address'],
                'phone' => $record['phone'],
                'job_title' => $record['job_title'],
                'job_description' => $record['job_description']
            ]);
            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Deactivate Employee.
     *
     * @param User $user
     *
     * @return void
     */
    public function deactivateEmployee(User $user)
    {
        try {
            if($user->type == self::EMPLOYEE) {
                $user->update(['status' => 0]);
            } else {
                throw new Exception('Can\'t deactivate a manager.', 403);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}
