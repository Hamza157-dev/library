<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class ِAuthController extends Controller
{
    function register(Request $request)
    {
        $supported_extensions = config('image.supported_extensions');
        $max_file_size =  config('image.max_file_size_small');
        $validated = $request->validate([
            'email'    => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],

            'name'     => ['required', 'string', 'max:255'],
            'gender' => ['required_if:type,customer', 'in:M,F'],
            'phone' => ['required',  'digits:10', 'unique:customers'],
            'DOB' => ['required', 'date', 'before:today'],
            'avatar' => ['nullable', 'image', "mimes:$supported_extensions", "max:$max_file_size"],
            'remember' => ['sometimes', 'boolean'],
        ]);
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('customer-avatars'); //we make 'public' disk is default
        }

        DB::transaction(function () use ($validated, $avatarPath) {

            $user = User::create([
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            $user->customer()->create([
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'phone' => $validated['phone'],
                'DOB' => $validated['DOB'],
                'avatar' => $avatarPath,
            ]);

            $remember = isset($validated['remember']);
            Auth::login($user, $remember);
        });

        $request->session()->regenerate();

        return apiSuccess("تم تسجيل الحساب بنجاح");
    }

    function login(Request $request)
    {

        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
            'remember' => ['sometimes', 'boolean'],
        ]);

        $remember = isset($validated['remember']);

        if (! Auth::attempt($request->only('email', 'password'),  $remember))
            throw ValidationException::withMessages(['email' => 'معلومات التوثق غير صحيحة']);

        $request->session()->regenerate();

        return apiSuccess("تم تسجيل الدخول بنجاح");
    }

    function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return apiSuccess("تم تسجيل الخروج بنجاح");
    }

    function changePassword(Request $request){
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],            
        ]);
        
        $request->user()->update([
            'password' => $validated['password'],
        ]);
        return apiSuccess("تم تغيير كلمة السر بنجاح");

    }
    
}
