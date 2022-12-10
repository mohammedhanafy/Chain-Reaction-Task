<?php

namespace App\Traits;

trait ApiResponser
{
    /**
     * Return success JSON Response.
     *
     * @param  array|null $data
     * @param  string $message
     * @param  integer $code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data = null, $message, $code = 200) {
		return response()->json([
			'status' => 'Success', 
			'message' => $message, 
			'data' => $data
		], $code);
	}

    /**
     * Return error JSON Response.
     *
     * @param  string $message
     * @param  integer $code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
	protected function errorResponse($message, $code = 500) {
		return response()->json([
			'status' => 'Error',
			'message' => $message
		], $code);
	}

    /**
     * Return validation JSON Response.
     *
     * @param  array $errors
     * @param  integer $code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validationResponse($errors, $code = 422) {
		return response()->json([
			'status' => 'Validation',
			'errors' => $errors
		], $code);
	}
}
