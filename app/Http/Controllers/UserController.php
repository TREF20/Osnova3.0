<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Создание нового пользователя
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    // Получение всех пользователей
    public function index()
    {
        return User::all();
    }

    // Получение конкретного пользователя
    public function show($id)
    {
        return User::findOrFail($id);
    }

    // Обновление пользователя
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user);
    }

    // Удаление пользователя
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(null, 204);
    }
}
