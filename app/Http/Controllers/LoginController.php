<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session as FacadesSession;

class LoginController extends Controller
{
    public function swapping($user) {
        $new_sessid   = Session::getId();
        $last_session = Session::getHandler()->read($user->last_sessid);
    
        if ($last_session) {
            if (Session::getHandler()->destroy($user->last_sessid)) {
                // session was destroyed
            }
        }
    
        $user->last_sessid = $new_sessid;
        $user->save();
    }
    public function home(){
        return view('home');
    }
    public function showLogin(){
        return view('login');
    }
    public function login(Request $request){
        $rules = [
            'email'=>'required|exists:users,email',
            'password'=>'required'


        ];
        


        $data = validator()->make($request->all(), $rules);

        if ($data->fails()) {
            return redirect()->back()->withErrors($data) ;
          
        } else {
            
        $credentials = $request->only('email', 'password');
            // if(Cookie::has('login')){
            //    return  "sorry you cannot log in ";
            // }
            // else{
                $user = User::where('email', $request->email)->first();
                if($user->session_id != '') {
                    return "sorry you logged in from another device";
                }
                if (Auth::attempt($credentials)) {
                    $new_sessid   = FacadesSession::getId(); //get new session_id after user sign in
                    User::where('id', $user->id)->update(['session_id' => $new_sessid]);

            }

               
    
                    return redirect('/home')->with('logged in ');
                
                return 'You entered invalid credentials';
            }
           
    
    }
    public function logout() {
       
        $user = Auth()->user()->id;
        User::where('id',$user)->update(['session_id'=>null]);
        Auth::logout();
        return redirect('/login');
      }
    
}
