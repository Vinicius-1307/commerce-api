<?php

namespace App\Http\Controllers\Product;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(CreateProductRequest $request)
    {
        return ReturnApi::Success('Produto criado.', Product::create($request->validated()));
    }

    public function update(UpdateProductRequest $request)
    {
        try {
            return ReturnApi::Success('Produto atualizado', Product::find($request->validated()['id'])->update($request->validated()));
        } catch (\Error $e) {
            throw new ApiException('Houve um erro ao atualizar o produto.', $e->getMessage());
        }
    }

    public function getAll()
    {
        return ReturnAPi::Success('Todos os produtos', Product::get());
    }
}
