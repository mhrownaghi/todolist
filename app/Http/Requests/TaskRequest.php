<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
            'end' => 'required|date',
            'priority' => 'required|numeric|between:1,10',
            'status' => [
                'required',
                Rule::in(['Incomplete', 'In progress', 'Completed']),
            ],
        ];
    }
}
