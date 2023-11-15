<?php

namespace App\Http\Requests\Product;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class FindProductRequest extends FormRequest
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
                'exists:products,id'
            ]
        ];
    }

    public function messages()
    {
        return [
            'id.integer' => 'O campo (id) deve ser um inteiro.',
            'id.required' => 'O campo (id) é obrigatório.',
            'id.exists' => 'O produto informado não existe.'
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
