<?php

namespace App\Http\Requests\Product;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'price' => [
                'required',
                'numeric',
                'min:0'
            ],
            'description' => [
                'required',
                'string'
            ],
            'category' => [
                'required',
                'string'
            ],
            'quantity' => [
                'required',
                'integer'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'O campo (name) deve ser uma string.',
            'name.required' => 'O campo (name) é obrigatório.',
            'price.numeric' => 'O campo (price) deve ser um número.',
            'price.min' => 'O campo (price) deve ser maior que 0.',
            'price.required' => 'O campo (price) é obrigatório.',
            'description.string' => 'O campo (description) deve ser uma string.',
            'description.required' => 'O campo (description) é obrigatório.',
            'category.string' => 'O campo (category) deve ser uma string.',
            'category.required' => 'O campo (category) é obrigatório.',
            'quantity.integer' => 'O campo (quantity) deve ser um número.',
            'quantity.required' => 'O campo (quantity) é obrigatório.',
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new ApiException($validator->errors()->first());
    }
}
