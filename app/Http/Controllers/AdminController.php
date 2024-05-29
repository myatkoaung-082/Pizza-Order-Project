<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function changePasswordPage(){

        // dd('changed');
        return view('admin.account.changePassword');
       }

       public function changePassword(Request $request){
        // dd($request->all());

        $this->passwordValidationCheck($request);

        $user = User::select('password')->where('id',Auth::user()->id)->first();

        $dbHashValue = $user->password;

        if(Hash::check($request->oldPassword,$dbHashValue)){
            $data = [
                'password' => Hash::make($request->newPassword),
            ];

            User::where('id',Auth::user()->id)->update($data);

            // Auth::logout();
            return back()->with(['changeSuccess' => 'Password Change Successful..']);
        }

        return back()->with(['notMatch' => 'The Old Password Not Match.Try Again!']);



       }

       private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:5',
            'newPassword' => 'required|min:5',
            'confirmPassword' => 'required|min:5|same:newPassword',
        ])->validate();
       }

       public function details(){
        return view('admin.account.details');
       }
}
