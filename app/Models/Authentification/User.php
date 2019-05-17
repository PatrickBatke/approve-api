<?php

namespace App\Models\Authentification;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Events\EmailVerificationlinkWasClicked;
use App\Models\Authentification\Password_reset;
use  Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public static function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')]) || Auth::attempt(['username' => request('email'), 'password' => request('password')])) {
            if (strpos(request('email'), '@') !== false) {
                if (!User::where('email', request('email'))->first()->verified) {
                    return response()->json(['error'=>'Account not verified'], 401);
                }
            } else {
                if (!User::where('username', request('email'))->first()->verified) {
                    return response()->json(['error'=>'Account not verified'], 401);
                }
            }
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $user->token=$success['token'];
            $user->save();

            // User-id und User-Token in der Session speichern
            session(['user_id' => $user->id]);
            session(['user_token' => $user->token]);
            // Tests:
            // $value = session('user_token', 'error');
            // return response()->json(['session' => $value]);

            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error'=>'Username or password is wrong!'], 401);
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public static function currentUser()
    {
        $id = session('user_id', 'error');
        $token = session('user_token', 'error');
        if ($id !== 'error' && $token !== 'error') {
            return response()->json(['user_id' => $id, 'user_token' => $token]);
        } else {
            return response()->json(['error'=>'No current User']);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public static function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['verified'] = 0;

        $user = User::create($input);

        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->username;

        $user->token = $success['token'];
        $user->save();

        Mail::send('emails.authentification.confirm-registration', ['user' => $user], function ($m) use ($user) {
            $m->to($user->email, $user->username)->subject('Verifiziere dein Approve-IT Konto!');
        });

        return response()->json(['success'=>$success], 200);
    }

    /**
     * Verify user registration with double opt-in
     *
     * @return \Illuminate\Http\Response
     */
    public function verify($id, $email, $token)
    {
        $user = User::where('id', '=', $id)->where('email', '=', $email)->where('token', '=', $token)->first();

        if ($user !== null) {
            $user->verified = 1;
            $user->save();
        }
    }

    /**
     * Reset Token
     *
     * @return \Illuminate\Http\Response
     */
    public static function resetToken($token, $type)
    {
        $saved = false;

        if ($type === "verify") {
            $user = User::where('token', '=', $token)->first();

            if ($user !== null) {
                $user->token = null;
                $saved = $user->save();
            }
        }

        if (!$saved) {
            return response()->json(['success'=>'failed']);
        } else {
            return response()->json(['success'=>'success']);
        }
    }




    /**
     * Check if user has been verified over Double-Opt-In
     *
     * @return \Illuminate\Http\Response
     */
    public static function checkIfVerified($id, $email, $token)
    {
        $user = User::where('id', '=', $id)->where('email', '=', $email)->where('token', '=', $token)->first();

        event(new EmailVerificationlinkWasClicked($user));

        $user = User::where('id', '=', $id)->where('email', '=', $email)->where('token', '=', $token)->first();

        if ($user->verified === 0) {
            return response()->json(['success'=>'failed']);
        } else {
            return redirect('http://localhost:4200/auth/verify');
        }
    }

    /**
     * Reset Password
     *
     * @return \Illuminate\Http\Response
     */
    public static function passwordReset()
    {
        $user = User::where('email', '=', request('email'))->where('token', '=', request('token'))->first();
        $saved = false;
        if (request('newpw') === request('newpw2') &&  $user !== null) {
            $user->password = bcrypt(request('newpw'));
            $saved = $user->save();
        }

        if ($saved === false) {
            return response()->json(['failed'=>'failed']);
        } else {
            $pwnew = new Password_reset;
            $pwnew->email = $user->email;
            $pwnew->token = $user->createToken('MyApp')->accessToken;
            $pwnew->created_at = Carbon::now();
            $pwnew->save();
            Mail::send('emails.authentification.pwreset-success', ['user' => $user], function ($m) use ($user) {
                $m->to($user->email, $user->username)->subject('Approve-IT | Dein Passwort wurde erfolgreich zurückgesetzt!');
            });

            return response()->json(['success'=>'success']);
        }
    }

    /**
     * Verify if Mail exists when forgot password
     *
     * @return \Illuminate\Http\Response
     */
    public function forgot()
    {
        $user = User::where('email', '=', request('email'))->first();

        if ($user === null) {
            return response()->json(['existing'=>'no']);
        } else {
            Mail::send('emails.authentification.pw-reset', ['user' => $user], function ($m) use ($user) {
                $m->to($user->email, $user->username)->subject('Approve-IT | Setze dein Passwort zurück!');
            });

            return response()->json(['existing'=>'yes']);
        }
    }
}