<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();
        $customer = $user->customer;
        $supported_extensions = config('image.supported_extensions');
        $max_file_size =  config('image.max_file_size_small');

        $validated = $request->validate([
            'email' => "required|email|unique:users,email,$user->id|max:255",
            'name' => 'required|string|max:255',
            'DOB' => 'required|date|before:today',
            'phone' => "required|digits:10|unique:customers,phone,$customer->id",
            'avatar' => "nullable|image|mimes:$supported_extensions|max:$max_file_size",
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($customer->avatar) Storage::delete('customer-avatars/' . $customer->avatar);

            $validated['avatar'] = $request->file('avatar')->store('customer-avatars');
        }
        $customer->update($validated);

        $customer->user()->update([
            'email' => $validated['email']
        ]);

        $customer->load('user');
        return apiSuccess('تم تحديث البيانات', new CustomerResource($customer));
    }

    function show(){
        $customer =  Auth::user()->customer;        
        $customer->load('user');

        return apiSuccess(__('library.customer-info'), new CustomerResource($customer));
    }

}
