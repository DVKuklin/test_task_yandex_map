<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request) {
        if (Auth::user()) {
            return redirect()->route('page.home');
        }

        $credentials = $request->validate([
            'name' => 'required',
            'email' => [
                            'required',
                            'email',
                            'unique:App\Models\User,email'
                        ],
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ], [
            'email.required' => 'Поле Email является обязательным',
            'email.email' => 'Недопустимый формат email',
            'email.unique' => 'Пользователь с таким email уже существует',
            'name.required' => 'Поле Имя является обязательным',
            'password.required' => 'Поле Пароль является обязательным',
            'password.confirmed' => 'Пароли не совпадают',
            'password_confirmation.required' => 'Поле Подтверждение пароля является обязательным',
        ]);

        try{
            $res = User::create([
                'name' => $credentials["name"], 
                'email' => $credentials["email"],
                'password' => Hash::make($credentials["password"])
            ]);
    
            if ($res) {
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
        
                    return redirect()->route('page.home')->with('success', 'Вы успешно зарегистрировались на сайте.');
                }

                return redirect()->route('page.register')->withErrors(['Что то пошло не так.','Ваши данные в базу записались, но авторизоваться Вы не смогли.','Попробуйте просто авторизоваться.']);

            }

            redirect()->route('page.register')->withErrors(['Что то пошло не так, попробуй ещё раз.']);

        }catch(Exception $e){
            return redirect()->route('page.register')->withErrors(['Что то пошло не так, попробуй ещё раз.']);
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('page.home')->with('success', 'Вы успешно вышли из приложения.');
    }

    public function login(Request $request) {
        if (Auth::user()) {
            return redirect()->route('page.home');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ], [
            'email.required' => 'Поле Email является обязательным',
            'password.required' => 'Поле Пароль является обязательным',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('page.home')->with('success', 'Вы успешно авторизовались на сайте.');
        }

        return redirect()->route('page.login')->withErrors(['Вы не авторизовались.','Возможно Вы ввели не верные данные.','Попробуйте еще раз.']);
    }
}
