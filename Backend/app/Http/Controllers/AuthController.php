<?php
namespace App\Http\Controllers;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{


    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        //dd ($user = DB::table('users')->where('email', $credentials['email'] )->first());
        $credentials['password'] = $this->run(substr($credentials['password'], 20, strlen($credentials['password']) - 40), -5);
        //dd($credentials['password']);
        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $userTokens = $user->tokens;
        foreach($userTokens as $token)
        {
            $token->revoke();
        }

        /*$requested_role = request(['role'])['role'];
        $requested_role_id = Role::where('name', 'like', '%' . $requested_role . '%')->firstOrFail()->id;
        if (strcmp($user->role_id, $requested_role_id))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        */
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        Auth::logoutOtherDevices($credentials['password']);
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {

        $user = $request->user();
        $user_role = $user->role->name;
        $user_id = $user->id;

        if ($user_role == "client")
        {
            return redirect()->action(
                'ClientController@show', ['id' => $user_id ]
            );
        }

        return response()->json(
            $request->user()
        );
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return $user;
    }
    /**
     * Change password of a user
     *
     * @param  [string] old_password
     * @param  [string] password
     * @param  [string] password_confirmed
     * @return [string] message
     */
    public function updatePassword(Request $request)
    {

        if ($request->password == '') {
            return response()->json([
                'error' => 'le champ password  est obligatoire !'
            ], 403);
        } if ($request->old_password == '') {
            return response()->json([
                'error' => 'le champ old_password  est obligatoire !'
            ], 403);
        } if ($request->password_confirmed == '') {
            return response()->json([
                'error' => 'le champ password_confirmed  est obligatoire !'
            ], 403);
        }
        if (Hash::check($request->old_password, Auth::user()->password))
        {
            if ( strcmp($request->password,$request->password_confirmed) != 0)
                return response()->json(['error' => 'Password do not match'], 401);
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['success' => 'Password updated with success']);
        }
        return response()->json(['error' => 'Wrong password'], 401);

    }
    protected function run($string, $key)
    {
        return implode('', array_map(function ($char) use ($key) {
            return $this->shift($char, $key);
        }, str_split($string)));
    }
    /**
     * Handles requests to shift a character by the given number of places.
     *
     * @param string $char
     * @param int    $shift
     *
     * @return string
     */
    protected function shift($char, $shift)
    {
        $shift = $shift % 25;
        $ascii = ord($char);
        $shifted = $ascii + $shift;

        if ($ascii >= 65 && $ascii <= 90) {
            return chr($this->wrapUppercase($shifted));
        }

        if ($ascii >= 97 && $ascii <= 122) {
            return chr($this->wrapLowercase($shifted));
        }

        return chr($ascii);
    }
    /**
     * Ensures uppercase characters outside the range of A-Z are wrapped to
     * the start or end of the alphabet as needed.
     *
     * @param int $ascii
     *
     * @return int
     */
    protected function wrapUppercase($ascii)
    {
        // Handle character code that is less than A.
        if ($ascii < 65) {
            $ascii = 91 - (65 - $ascii);
        }

        // Handle character code that is greater than Z.
        if ($ascii > 90) {
            $ascii = ($ascii - 90) + 64;
        }

        // Return unchanged character code.
        return $ascii;
    }
    /**
     * Ensures lowercase characters outside the range of a-z are wrapped to
     * the start or end of the alphabet as needed.
     *
     * @param int $ascii
     *
     * @return int
     */
    protected function wrapLowercase($ascii)
    {
        // Handle character code that is less than a.
        if ($ascii < 97) {
            $ascii = 123 - (97 - $ascii);
        }

        // Handle character code that is greater than z.
        if ($ascii > 122) {
            $ascii = ($ascii - 122) + 96;
        }

        // Return unchanged character code.
        return $ascii;
    }

}
