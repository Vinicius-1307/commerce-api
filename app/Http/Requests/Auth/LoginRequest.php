<?php

namespace App\Http\Requests\Auth;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'email' => [
                'string',
                'email',
                'required',
                'exists:users,email'
            ],
            'password' => [
                'string',
                'required'
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.string' => 'O campo (email) deve ser uma string.',
            'email.required' => 'O campo (email) é obrigatório.',
            'email.email' => 'O campo (email) deve ser um e-mail válido.',
            'email.exists' => 'Este e-mail não foi encontrado no sistema.',
            'password.string' => 'O campo (password) deve ser uma string.',
            'password.required' => 'O campo (password) é obrigatório.'
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new ApiException($validator->errors()->first());
    }
}
