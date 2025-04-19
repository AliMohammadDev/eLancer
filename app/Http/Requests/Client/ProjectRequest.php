<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.

     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'type' => ['required', 'in:hourly,fixed'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],

        ];
    }

    //function optional
    public function messages()
    {
        return [
            'title.required' => 'title is required',
            //
        ];
    }
}
