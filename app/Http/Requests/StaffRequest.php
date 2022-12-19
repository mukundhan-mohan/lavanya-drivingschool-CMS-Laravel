<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffRequest extends FormRequest
{
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
        $user = $this->route('user');
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required',
                    'email' => 'required',
                    'password'   => 'required',
                    'phone_number' => 'required',
                    'user_type' => 'required',
                    'status' => 'required'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'first_name' => 'required',
                    'last_name'  => 'required',
                    'email' => 'required',
                    'phone_number' => 'nullable',
                    'user_type' => 'required',
                    'status' => 'required'
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'year_2020.integer' => 'The year 2020 points must be an integer.',
            'year_2021.integer'  => 'The year 2021 points must be an integer.',
            'year_2022.integer' => 'The year 2022 points must be an integer.',
            'year_2023.integer' => 'The year 2023 points must be an integer.',
        ];
    }
}
