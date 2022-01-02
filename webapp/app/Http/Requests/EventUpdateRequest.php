<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
        return [
            'title' => 'nullable|string|min:1',
            'event_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100,ratio=1',
            'description' => 'nullable|string|min:1',
            'location' => 'nullable|string|min:1',
            'realization_date' => 'nullable|date|after:today',
            /*'is_visible' => 'string',
            'is_accessible' => 'string',*/
            'capacity' => 'nullable|integer',
            'price' => 'nullable|digits_between:0,8'
        ];
    }
}
