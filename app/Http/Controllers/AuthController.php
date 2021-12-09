<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Auth;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Create the user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->symbols(), 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->error([
                $validator->messages()
            ], '', 401);
        }

        $data = $validator->safe()->only(['name', 'email', 'password']);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ]);

    }

    /**
     * Authenticate user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $data = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if(!Auth::attempt($data)) {
            return $this->error('','Credentials do not match', 401);
        }

        return $this->success([
            'token' => Auth::user()->createToken('API Token')->plainTextToken
        ]);

    }

    /**
     * Destroy user tokens
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return $this->success('', 'You are logged out');
    }
}
