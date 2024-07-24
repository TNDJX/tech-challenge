<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:190',
            'email' => 'required_without:phone|nullable|email',
            'phone' => 'required_without:email|nullable|regex:/^[\d\s\+]+$/',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'The phone number can only contain digits, spaces, and a plus sign.',
        ];
    }
}
