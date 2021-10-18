<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|alpha|min:2|max:15',
            'last_name' => 'required|alpha||min:2|max:15',
            'ci' => 'required',
            'age' => 'required',
            'phone_mobile' => 'required',
            'phone_house' => 'required',
        ];
    }
}
