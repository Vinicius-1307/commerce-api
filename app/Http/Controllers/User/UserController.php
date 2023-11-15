<?php

namespace App\Http\Controllers\User;

use App\Builder\ReturnApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        $data = $request->validated();
        try {
            return ReturnApi::Success('Usuário criado com sucesso', User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]));
        } catch (\Error $error) {
            return ReturnApi::Error('Ocorreu um erro ao criar o usuário', $error->getMessage(), 400);
        }
    }

    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();
        try {
            $user = User::find($data['id']);
            $user->name = $data['name'];
            $user->email = $data['email'];
            if ($data['password']) {
                $user->password = bcrypt($data['password']);
            }
            $user->update();
            return ReturnApi::Success('Usuário atualizado com sucesso.', $user);
        } catch (\Error $error) {
            return ReturnApi::Error('Ocorreu um erro ao criar o usuário', $error->getMessage(), 400);
        }
    }
}
