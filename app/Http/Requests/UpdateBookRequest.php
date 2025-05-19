<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'title'             => 'required|string|max:255',
            'publisher'         => 'nullable|string|max:255',
            'edition'           => 'nullable|string|max:50',
            'publication_year'  => 'required|digits:4|integer|min:1500|max:' . date('Y'),
            'author_ids'        => 'required|array|min:1',
            'author_ids.*'      => 'exists:authors,id',
            'subject_ids'       => 'required|array|min:1',
            'subject_ids.*'     => 'exists:subjects,id',
        ];
    }
}
