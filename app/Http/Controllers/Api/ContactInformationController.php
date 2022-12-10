<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\UpdateContactInformationRequest;

class ContactInformationController extends ApiController
{        
    /**
     * Update Current Employee Contact Information.
     *
     * @param  \App\Http\Requests\Api\UpdateContactInformationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateContactInformation(UpdateContactInformationRequest $request) 
    {
        try {
            auth()->user()->contact_information()->updateOrCreate([
                'user_id'   => auth()->user()->id,
            ],
            [
                'address' => $request->address,
                'phone' => $request->phone,
                'job_title' => $request->job_title,
                'job_description' => $request->job_description
            ]);
            return $this->successResponse(null, 'User Information updated successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
