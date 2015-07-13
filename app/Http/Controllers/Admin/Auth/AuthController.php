<?php namespace App\Http\Controllers\Admin\Auth;

use Hash;
use Auth;
use Validator;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest.admin', ['except' => ['authenticate','logout']]);
	}
    
    public function index()
    {
        return view('admin.auth.login');
    }
    
    /**
	 * Auth Attempt
	 *
	 * @return Response
	 */
    public function authenticate(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');
        
        if (Auth::attempt(['email' => $email, 'password' => $password, 'admin' => 1], $remember)) {
            $result = array('status' => 'success', 'message' => 'You have successfully login!');
            
            return response()->json($result);
        } else {
            $result = array('status' => 'failed', 'message' => 'Email or Password is incorrect!');
            
            return response()->json($result);
        }
    }
    
    /**
	 * Auth Logout
	 *
	 * @return Response
	 */
    public function logout()
    {
        Auth::logout();
        
        return redirect()->intended('/administrator/login');
    }

}
