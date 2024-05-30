<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCategoryFormRequest extends FormRequest
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
        // dd($this);
        return [
            'name' => ['required'],
            'image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:10240'],
            'icon' => ['nullable', 'mimes:jpg,jpeg,png', 'max:10240']
        ];
    }
}
