<?php
namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function __construct()
    {
    }
   
   /* user registration */
    public function register(Request $request) {
        $data['title'] = 'Chat Application | Register';
        return view('register', $data);
    }

    /* save user form */
    public function postSignUp(Request $request) {
        $input = $request->all();
        
        $user = new User();
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->save();

        if(!$user) {
             return redirect()->back()->withErrors(['msg', 'Registration Failed.']);
        } 
        Auth::login($user);
        User::where('id', $user->id)->update(array('status' => 1, 'last_logged_in' => date('Y-m-d H:i:s')));
        return redirect('user/dashboard');
    }

    /* login user */
    public function login() {
        $data['title'] = 'Chat Application | Login';
        return view('login', $data);
    }

    /* login from database */
    public function postSignIn(Request $request) {
        $input = $request->all();

        $userdata = array(
            'email' => $input['email'],
            'password' => $input['password']
        );
       
        // attempt to do the login
        if (Auth::attempt($userdata)) {   
             User::where('id', Auth::user()->id)->update(array('status' => 1, 'last_logged_in' => date('Y-m-d H:i:s')));         
            return redirect('user/dashboard');
        } else {
            return redirect()->back()->withErrors(['msg', 'Invalid login attempt']);
        }
    }
    
    /* check user have already email exist */
    public function checkEmail(Request $request) {
        $email = $request->get('email');

        $user = User::where('email', $email)->first();
        if(isset($user) && !empty($user)) {
            echo 'exist';
        } else {
            echo 'not exist';
        }

    }  
}