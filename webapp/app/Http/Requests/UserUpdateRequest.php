<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'nullable|string|min:1|max:255|unique:users',
            'name' => 'nullable|string|min:1|max:255',
            'profile_pic' => 'nullable|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100,ratio=1',
            'description' => 'nullable|string|min:1|max:8192',
            'email' => 'nullable|email|min:1|max:255|unique:users',
            'password' => 'nullable|string|min:6|confirmed',
            'birthdate' => 'nullable|date|before:today'
        ];
    }
}