<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'user_id' => [
                'required',
                'exists:users,id'
            ],
            'products' => [
                'required',
                'array'
            ],
            'products.*.product_id' => [
                'required',
                'exists:products,id'
            ],
            'products.*.quantity' => [
                'required',
                'integer',
                'min:1'
            ],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'O campo (user_id) é obrigatório.',
            'user_id.exists' => 'O usuário não existe.',
            'products.required' => 'O campo (products) é obrigatório.',
            'products.array' => 'O campo (products) deve ser um array.',
            'products.*.product_id.required' => 'O campo (product_id) é obrigatório.',
            'products.*.product_id.exists' => 'O produto não existe.',
            'products.*.quantity.required' => 'O campo (product_id) é obrigatório.',
            'products.*.quantity.integer' => 'O campo (quantity) deve ser um inteiro.',
            'products.*.quantity.min' => 'O campo (quantity) deve ser maior que zero.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->input('user_id', null),
            'products' => $this->input('products', null),
        ]);
    }

    public function failedValidation(Validator $validator): void
    {
        throw new ApiException($validator->errors()->first());
    }
}
