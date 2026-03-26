<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Создание нового заказа
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create($request->all());

        return response()->json($order, 201);
    }

    // Получение всех заказов
    public function index()
    {
        return Order::with(['user', 'product'])->get();
    }

    // Получение конкретного заказа
    public function show($id)
    {
        return Order::with(['user', 'product'])->findOrFail($id);
    }

    // Обновление заказа
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json($order);
    }

    // Удаление заказа
    public function destroy($id)
    {
        Order::destroy($id);
        return response()->json(null, 204);
    }
}
