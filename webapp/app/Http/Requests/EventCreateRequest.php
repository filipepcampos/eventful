<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventCreateRequest extends FormRequest
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
            'title' => 'required|string|min:1',
            'event_image' => 'required|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100,ratio=1',
            'description' => 'required|string|min:1',
            'location' => 'required|string|min:1',
            'realization_date' => 'required|date|after:today',
            /*'is_visible' => 'string',
            'is_accessible' => 'string',*/
            'capacity' => 'integer',
            'price' => 'digits_between:0,8'
        ];
    }
}
