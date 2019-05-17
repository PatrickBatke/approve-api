<?php

namespace App\Http\Controllers\Authentification;

use App\Http\Controllers\Controller;
use App\Models\Authentification\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return User::login();
    }
    /**
     * Current User api
     *
     * @return \Illuminate\Http\Response
     */
    public function currentUser()
    {
        return User::currentUser();
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        return User::register($request);
    }
    /**
     * Reset token
     *
     * @return \Illuminate\Http\Response
     */
    public function resetToken()
    {
        return User::resetToken(request('token'), request('type'));
    }

    /**
     * Verify user registration with double opt-in
     *
     * @return \Illuminate\Http\Response
     */
    public function verify($id, $email, $token)
    {
        return User::checkIfVerified($id, $email, $token);
    }

    /**
     * Reset Password
     *
     * @return \Illuminate\Http\Response
     */
    public function passwordReset()
    {
        // $user = User::where('email', '=', request('email'))->where('token', '=', request('token'))->first();
        return User::passwordReset();
    }

    /**
     * Verify if Mail exists when forgot password
     *
     * @return \Illuminate\Http\Response
     */
    public function forgot()
    {
        $user = User::where('email', '=', request('email'))->first();
        return $user->forgot();
    }
}
