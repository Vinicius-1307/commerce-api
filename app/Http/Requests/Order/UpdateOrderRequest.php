<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
                'exists:order_details,id'
            ],
            'products' => [
                'array'
            ],
            'products.*.product_id' => [
                'exists:products,id'
            ],
            'products.*.quantity' => [
                'integer',
                'min:1'
            ],
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'O campo (id) é obrigatório.',
            'id.integer' => 'O campo (id) deve ser um número.',
            'id.exists' => 'O pedido não existe.',
            'products.array' => 'O campo (products) deve ser um array.',
            'products.*.product_id.exists' => 'O produto não existe.',
            'products.*.quantity.integer' => 'O campo (quantity) deve ser um inteiro.',
            'products.*.quantity.min' => 'O campo (quantity) deve ser maior que zero.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'products' => $this->input('products', null),
            'id' => $this->route('order_id')
        ]);
    }

    public function failedValidation(Validator $validator): void
    {
        throw new ApiException($validator->errors()->first());
    }
}
