<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (isset($data['avatar'])) {
            $avatarName = $user->id . '_avatar' . time() . '.' . $data['avatar']->getClientOriginalExtension();
            $data['avatar']->move(public_path('image'), $avatarName);
            $user->avatar = $avatarName;
            $user->save();
        }

        $clienteRole = Role::where('name', 'cliente')->first();
        if ($clienteRole) {
            $user->assignRole($clienteRole);
        }

        return $user;
    }
}