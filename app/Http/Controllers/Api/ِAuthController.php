<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ِAuthController extends Controller
{
    function register(Request $request)   {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],            
        ]);
        $user = User::create($validated);
        $remember = $request->boolean('remember');
       
        Auth::login($user , $remember  );

        $request->session()->regenerate();

        return ResponseHelper::success("تم تسجيل الحساب بنجاح");
    }
    
    function login(Request $request){
          $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],            
        ]);
        if ( ! Auth::attempt($credentials ,    ))
            throw ValidationException::withMessages(['email' => 'معلومات التوثق غير صحيحة']);

        $request->session()->regenerate();

        return ResponseHelper::success("تم تسجيل الدخول بنجاح");

    }
    function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return ResponseHelper::success("تم تسجيل الخروج بنجاح");

    }

    
}
