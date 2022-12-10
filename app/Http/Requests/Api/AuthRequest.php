<?php

namespace App\Http\Requests\Api;

use App\Traits\ApiResponser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class AuthRequest extends FormRequest
{
    use ApiResponser;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (request()->segment(count(request()->segments()))) {
            case 'register':
                return [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|confirmed|min:8',
                    'type' => 'required|in:employee,manager'
                ];
            case 'login': {
                return [
                    'email' => 'required|email',
                    'password' => 'required'
                ];
            }
            default:
                break;
        }
    }

     /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->validationResponse($validator->errors()));
    }
}
