<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;

class AuthController extends Controller
{

    /**
     * Display login of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        $title = "Login";
        $description = "Some description for the page";
        return view('auth.login', compact('title', 'description'));
    }

    /**
     * Display register of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        $title = "Register";
        $description = "Some description for the page";
        return view('auth.register', compact('title', 'description'));
    }

    /**
     * Display forget password of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function forgetPassword()
    {
        $title = "Forget Password";
        $description = "Some description for the page";
        return view('auth.forget_password', compact('title', 'description'));
    }

    /**
     * make the user able to register
     *
     * @return 
     */
    public function signup(Request $request)
    {

       

        $validators = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|phone|unique:users',
            'password' => 'required'
        ]);
        if ($validators->fails()) {
            return redirect()->route('register')->withErrors($validators)->withInput();
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            auth()->login($user);
            return redirect()->intended(route('dashboard.demo_one', 'en'))->with('message', 'Registration was successfull !');
        }
    }

    /**
     * make the user able to login
     *
     * @return 
     */
    public function authenticate(Request $request)
    {

        date_default_timezone_set('Asia/Dhaka');
        $validators = Validator::make($request->all(), [
            'phone' => 'required|phone',
            'password' => 'required'
        ]);
        // if ($validators->fails()) {
        //     return redirect()->route('login')->withErrors($validators)->withInput();
        // } else {
            $user_status = User::where('phone',$request->phone)->select('status')->first();
           // dd($user_status);
           // if()

           if(isset($user_status)){
            if($user_status->status == 0){
            return redirect()->route('login')->with('error', 'Login Failed. Your Mobile Number or password is incorrect!');
            }
           }
            if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
                User::where('phone', $request->phone)->update(['is_active' => 1]);
                User::where('id', Auth::user()->id)->update(['last_seen' => now()]);
                return redirect()->intended(route('home'))->with('success', 'Welcome back !');
            } else {
                return redirect()->route('login')->with('error', 'Login Failed. Your Mobile Number or password is incorrect!');
            }
       // }
    }

    /**
     * make the user able to logout
     *
     * @return 
     */
    public function logout()
    {
        User::where('id', Auth::user()->id)->update(['is_active' => 0]);
        Auth::logout();
        return redirect()->route('login')->with('message', 'Successfully Logged out !');
    }
}
