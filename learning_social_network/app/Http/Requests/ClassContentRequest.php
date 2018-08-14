<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassContentRequest extends FormRequest
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
            'class_id' => 'required',
            'title' => 'required',
            'thumbnail' => 'required',
            'level' => 'required',
            'duration' => 'required',
            'documents' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'author' => 'required',
            'is_done' => 'required',
            'is_approve' => 'required',
        ];
    }
}
