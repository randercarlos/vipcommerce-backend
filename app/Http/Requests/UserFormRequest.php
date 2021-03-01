<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            'name' => 'required|min:3|max:60',
            'email' => 'required|max:60|email',
            'gender' => 'required|min:6|max:15',
            'birthday' => 'required|date_format:d/m/Y',
            'id_value' => 'required|min:3|max:15|alpha_dash',
            'phone' => 'required|min:5|max:20',
            'nat' => 'required|min:2|max:2|alpha',
            'street' => 'required|min:5|max:100',
            'number' => 'required|min:1|max:10|alpha_dash',
            'city' => 'required|min:3|max:20',
            'state' => 'required|min:2|max:20',
            'country' => 'required|min:3|max:20',
            'postcode' => 'required|min:5|max:10',
        ];
    }
}
