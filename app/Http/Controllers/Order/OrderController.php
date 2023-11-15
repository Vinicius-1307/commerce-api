<?php

namespace App\Http\Controllers\Order;

use App\Builder\ReturnApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(CreateOrderRequest $request)
    {
        $data = $request->validated();

        $order = Order::create([
            'user_id' => $data['user_id']
        ]);

        foreach ($data['products'] as $product) {
            OrderDetail::create([
                'order_id' => $order->id,
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
}
