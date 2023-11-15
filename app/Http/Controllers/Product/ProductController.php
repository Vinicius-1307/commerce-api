<?php

namespace App\Http\Controllers\Product;

use App\Builder\ReturnApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(CreateProductRequest $request)
    {
        return ReturnApi::Success('Produto criado.', Product::create($request->validated()));
    }
}
