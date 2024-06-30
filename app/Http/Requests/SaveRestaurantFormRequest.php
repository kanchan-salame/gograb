<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveRestaurantFormRequest extends FormRequest
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
            'image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:10240'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'min_order_price' => ['required'],
            'delivery_fee' => ['required'],
            'delivery_max_time' => ['required'],
            'delivery_min_time' => ['required'],
        ];
    }
}
