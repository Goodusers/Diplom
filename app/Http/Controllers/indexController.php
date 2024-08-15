<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\mail\regiMail;

use function PHPSTORM_META\map;

class indexController extends Controller
{
    public function index(){
        return view("index");
    }
    public function register(){
        return view("register");
    }
    public function auth_form(Request $request){
        $validate = $request->validate([
            'email' => ['required'],
            'password' => ['required', 'min:6']
        ],[
            'email.required' => 'Поле не может быть пустым',
            'password.required' => 'Поле не может быть пустым',
            'password.min' => 'Минимальное количество символов: 6',
        ]);
        
        $formValue = $request->only(['email', 'password']);
        if(Auth::attempt($formValue)){
            $online = User::findOrFail(Auth::user()->id);
            if($online->role == 1){
                $online->is_service = 'online';
                $online->save();
                return redirect(url('/admin'.'/'. Auth::user()->username));
            }
            else{
                $online->is_service = 'online';
                $online->save();
                return redirect(url('/account'.'/'. Auth::user()->username));
            }

        }
        return redirect(route('index'))->withErrors(['password'=>'Не удалось авторизироваться']);
    }
    public function register_form(Request $request_registr){
        if(Auth::check()){
            return redirect(route('index'));
        }
        $validate = $request_registr->validate([
            'email' => ['required', 'email', 'unique:users',  'regex:/@(gmail|email|yandex|ya|mail)/'],
            'username' => ['required'],
            'password' => ['required', 'min:6'],
            'password-repeat' => ['required', 'same:password'],
            'phone' => ['required', 'unique:users'],
            'city' => ['required'],
        ],[
            'email.required' => "Обязательное поле",
            'username.required' => "Обязательное поле",
            'password.required' => "Обязательное поле",
            'password-repeat.required' => "Обязательное поле",
            'phone.required' => "Обязательное поле",
            'city.required' => "Обязательное поле",

            'email.email' => "Поле должно содержать '@' ",
            'email.unique' => "Почта занята другим пользователем",
            'password-repeat.same' => "Пароли не совпадают",
            'phone.unique' => "Номер уже зарегистрирован в системе",
            'password.min' => "Минимальное количество символов: 6"
        ]);
        $user = User::create([
            'username'=>$validate['username'],
            'email'=>$validate['email'],
            'password'=>$validate['password'],
            'phone'=>$validate['phone'],
            'city'=>$validate['city'],
            'token' =>'@'.$request_registr->username.rand(1,100),
            'role' => 0,
            'photo' => 'user.png'
        ]);
        
            $title = 'PULSE';
            $body = 'Уведомление о успешной регистрации';
            
     
        if(Mail::to($validate['email'])->send(new regiMail($title, $body, $validate['username']))){
            Auth::loginUsingId($user->id);
            return redirect(url('/account'.'/'. Auth::user()->username));
        }
        else{
            return redirect()->back();
        }

    }

}
