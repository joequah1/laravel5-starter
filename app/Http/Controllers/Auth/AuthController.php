<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
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
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['authenticate','logout']]);
    }
    
    public function index()
    {
        return view('user.auth.login');
    }
    

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    
    protected function create()
    {
        return view('user.auth.register');
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), User::$rules);
        
        if ($validator->fails()) {
            $result = array('status' => 'failed', 'error' => $validator->errors());
            
            return response()->json($result);
        }
        
		$email = $request->input('email');
        $name = $request->input('name');
        $password = bcrypt($request->input('password'));
        $admin = $request->input('admin',0);
        
        $input = new User;
        $input->email = $email;
        $input->name = $name;
        $input->password = $password;
        $input->admin = $admin;
        
        $input->save();
        
        $result = array('status' => 'success', 'message' => 'You have successfully registered!');
            
        return response()->json($result);
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
        
        if (Auth::attempt(['email' => $email, 'password' => $password, 'admin' => 0], $remember)) {
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
        
        return redirect()->intended('/login');
    }
}
