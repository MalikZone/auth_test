<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{

    public function index(){
        return view('auth.passwords.change');
    }

    public function changepassword(Request $request){
        $this->validate($request, [
            "oldpassword"           => 'required',
            'password'              => 'required|confirmed',
        ]);

        $hashedpassword = Auth::user()->password;
        if (Hash::check($request->oldpassword, $hashedpassword)) {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();

            return redirect()->route('login')->with('successMsg', 'Password is change successfully');
        }
        else{
            return redirect()->back()->with('errorMsg', 'Current password is invalid');
        }
    }

}
