<?php

namespace App\Http\Requests\User;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'id' => [
                'required',
                'integer',
                'exists:users,id'
            ],
            'name' => [
                'required',
                'string'
            ],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->whereNot('id', $this->route('user_id'))
            ],
            'password' => [
                'sometimes',
                'nullable',
                'string',
                'min:8'
            ]
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
            'password.nullable' => 'O campo (password) não pode ser nulo.',
            'password.min' => 'O campo (password) deve conter no mínimo 8 caracteres.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('user_id'),
            'password' => $this->input('password', null)
        ]);
    }

    public function failedValidation(Validator $validator): void
    {
        throw new ApiException($validator->errors()->first());
    }
}
