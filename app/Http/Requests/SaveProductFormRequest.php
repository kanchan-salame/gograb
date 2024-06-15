<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProductFormRequest extends FormRequest
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
            'quantity' => ['required'],
            'price' => ['required'],
            'unit' => ['required'],
            'description' => ['required'],
            'product_category_id' => ['required'],
            'product_sub_category_id' => ['nullable'],
            'image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:10240'],
        ];
    }
}
