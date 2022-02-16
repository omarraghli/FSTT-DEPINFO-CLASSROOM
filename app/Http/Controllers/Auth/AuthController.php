<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /**
         * The email will check for a valid NJIT address (ending with "@njit.edu")
         * 
         */
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $role = 'entreprise';  
        $regex_teacher = '/^[a-z]{2,4}+\d{1,4}@njit\.com$/';

        /**
         * Assign the appropriate role based on the regular expression
         * for a students' email
         * 
         */
        if (preg_match($regex_teacher, $data['email'])) {
            $role = 'teacher';
        }
        return User::create([
            'first_name' => $data['first_name'],
            'role' => $role,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'address' => $data['address'],
        ]);
    }
}
