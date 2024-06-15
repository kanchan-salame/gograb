<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveServiceFormRequest extends FormRequest
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
            'name' => ['required'],
            'service_category_id' => ['required'],
            'service_sub_category_id' => ['nullable'],
            'image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:10240'],
        ];
    }
}
