<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentScoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first' => 'numeric|integer',
            'second' => 'numeric|integer',
            'third' => 'numeric|integer',
            'fourth' => 'numeric|integer',
        ];
    }
}
