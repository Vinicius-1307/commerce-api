<?php

namespace App\Http\Requests\User;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => [
                'string',
                'required'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:8'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Senha'
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'O campo (name) deve ser uma string.',
            'name.required' => 'O campo (name) é obrigatório.',
            'email.string' => 'O campo (email) deve ser uma string.',
            'email.required' => 'O campo (email) é obrigatório.',
            'email.email' => 'O campo (email) deve ser um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado no sistema.',
            'password.string' => 'O campo (password) deve ser uma string.',
            'password.required' => 'O campo (password) é obrigatório.',
            'password.min' => 'O campo (password) deve conter no mínimo 8 caracteres.',
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new ApiException($validator->errors()->first());
    }
}
