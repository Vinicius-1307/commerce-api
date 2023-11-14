<?php

namespace App\Http\Controllers\User;

use App\Builder\ReturnApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        $data = $request->validated();
        try {
            return ReturnApi::Success('Usuário criado com sucesso', $data, User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]));
        } catch (\Error $error) {
            return ReturnApi::Error('Ocorreu um erro ao criar o usuário', $error->getMessage(), 400);
        }
    }
}
