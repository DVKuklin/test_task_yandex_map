<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'password_confirm' => ['required']

        ], [
            'email.required' => 'Поле Email является обязательным',
            'name.required' => 'Поле Имя является обязательным',
            'password.required' => 'Поле Пароль является обязательным',
            'password_confirm.required' => 'Поле Подтверждение пароля является обязательным',
        ]);

        if ($credentials["password"] != $credentials["password_confirm"]) {
            return redirect()->route('page.register')->withErrors(['Пароли не совпадают']);
        }

        try{
            $res = User::where('name',$credentials["name"])
                        ->where('email',$credentials["email"])
                        ->first();
            
            if ($res) {
                return redirect()->route('page.register')->withErrors(['Пользователь с такими данными уже существует.']);
            } 

            $res = User::create([
                'name' => $credentials["name"], 
                'email' => $credentials["email"],
                'password' => Hash::make($credentials["password"])
            ]);
    
            if ($res) {
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
        
                    return redirect()->route('page.home')->with('success', 'Вы успешно зарегистрировались на сайте.');
                } else {
                    return redirect()->route('page.register')->withErrors(['Что то пошло не так.','Ваши данные в базу записались, но авторизоваться Вы не смогли.','Попробуйте просто авторизоваться.']);
                }
            } else {
                redirect()->route('page.register')->withErrors(['Что то пошло не так, попробуй ещё раз.']);
            }


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
        } else {
            return redirect()->route('page.login')->withErrors(['Вы не авторизовались.','Возможно Вы ввели не верные данные.','Попробуйте еще раз.']);
        }
    }
}
