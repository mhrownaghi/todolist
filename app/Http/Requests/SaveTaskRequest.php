<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveTaskRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'priority' => 'required|numeric|between:1,10',
            'status' => [
                'required',
                Rule::in(['Incomplete', 'In Progress', 'Completed']),
            ],
            'description' => '',
        ];
    }
}
