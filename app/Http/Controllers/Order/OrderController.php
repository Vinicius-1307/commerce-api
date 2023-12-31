<?php

namespace App\Http\Controllers\Order;

use App\Builder\ReturnApi;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\DeleteOrderRequest;
use App\Http\Requests\Order\GetOrdersRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create(CreateOrderRequest $request)
    {
        $data = $request->validated();
        $user = Auth::id();

        foreach ($data['products'] as $product) {
            $productHasStock = Product::find($product['product_id']);
            if ($productHasStock->stock < $product['quantity']) throw new ApiException('Estoque insuficiente para o produto.');
            OrderDetail::create([
                'user_id' => $user,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ]);
            $this->updateProductStock($product['product_id'], $product['quantity']);
        }
        return ReturnApi::Success('Pedido criado.', $product);
    }

    public function updateProductStock($productId, $quantity)
    {
        $product = Product::find($productId);
        $product->decrement('stock', $quantity);
    }

    public function get()
    {
        return ReturnApi::Success('Pedidos', OrderDetail::get());
    }

    public function getByUser()
    {
        $orders = OrderDetail::select(
            'products.name',
            'products.price',
            'order_details.quantity'
        )
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('order_details.user_id', Auth::id())
            ->get();

        return ReturnApi::Success('Pedidos do usuário', $orders);
    }

    public function delete(DeleteOrderRequest $request)
    {
        try {
            return ReturnApi::Success('Pedido deletado.', OrderDetail::find($request->validated()['id'])->delete());
        } catch (\Error $e) {
            throw new ApiException('Houve um erro ao deletar o pedido.', $e->getMessage());
        }
    }

    public function update(UpdateOrderRequest $request)
    {
        $data = $request->validated();
        $userId = Auth::id();
        $productUsers = [];
        try {
            foreach ($data['products'] as $product) {
                $product = OrderDetail::find($data['id']);
                if ($product) {
                    $product->update([
                        'user_id' => $userId,
                        'product_id' => $product['product_id'],
                        'quantity' => $product['quantity'],
                    ]);
                }
                $this->updateProductStock($product['product_id'], $product['quantity']);
                $productUsers = $product;
            }
            return ReturnApi::Success('Pedido atualizado.', $productUsers);
        } catch (\Error $e) {
            throw new ApiException('Houve um erro ao atualizar o pedido.', $e->getMessage());
        }
    }
}
