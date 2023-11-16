<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class DeleteOrderRequest extends FormRequest
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
            ]
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'O campo (id) é obrigatório.',
            'id.integer' => 'O campo (id) deve ser um número.',
            'id.exists' => 'O pedido não existe.'
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('order_id')
        ]);
    }

    public function failedValidation(Validator $validator): void
    {
        throw new ApiException($validator->errors()->first());
    }
}
