<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\ShopOption;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showLogin()
    {
        $color = ShopOption::Where('meta_key', 'main_color')->first()['meta_value'];
        $logo  = ShopOption::Where('meta_key', 'logo_path')->first()['meta_value'];

        if($color != null && $color != null ){

            return view('auth.login', compact('color', 'logo'));
        } else {
            return view('auth.login');
        }
    }
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function forgot_password(Request $request)
    {
        $user = User::where('email', $_REQUEST['email'])->first();

        if($user == null){
            return response(['status' => 'error', 'message' => 'Invalid email address']);
        } else {
            $new_pw = str_random(20);
            $user->password = Hash::make($new_pw);
            $user->save();

            $to = $user->email;
            $subject = "Reset password";
            $txt = "Your new password is: " . $new_pw . " login and change the password";
            $headers = "From: beats@transactionmusic.com";
            $headers .= "From: " . strip_tags('beats@transactionmusic.com') . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            mail($to,$subject,$txt,$headers);

            return response(['status' => 'success', 'message' => 'Your new password is sent to your mail address']);

        }
    }
}
