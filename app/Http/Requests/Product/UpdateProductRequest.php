<?php

namespace App\Http\Requests\Product;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
                'integer',
                'required',
                'exists:products,id'
            ],
            'name' => [
                'string',
                'nullable'
            ],
            'price' => [
                'nullable',
                'numeric',
                'min:0'
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'category' => [
                'nullable',
                'string'
            ],
            'quantity' => [
                'nullable',
                'integer'
            ]
        ];
    }

    public function messages()
    {
        return [
            'id.integer' => 'O ID deve ser um número inteiro.',
            'id.required' => 'O ID é obrigatório para atualização.',
            'id.exists' => 'O produto informado não foi encontrado.',
            'name.string' => 'O campo (name) deve ser uma string.',
            'price.numeric' => 'O campo (price) deve ser um número.',
            'price.min' => 'O campo (price) deve ser maior que 0.',
            'description.string' => 'O campo (description) deve ser uma string.',
            'category.string' => 'O campo (category) deve ser uma string.',
            'quantity.integer' => 'O campo (quantity) deve ser um número.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('product_id')
        ]);
    }

    public function failedValidation(Validator $validator): void
    {
        throw new ApiException($validator->errors()->first());
    }
}
