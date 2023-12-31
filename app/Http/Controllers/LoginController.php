<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Interfaces\IUserRepository;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function __construct(private IUserRepository $userRepositoryInterface)
    {
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        try {
            if (auth()->guard('api')->attempt($request->safe()->only('email', 'password'))) {
                $user = auth()->guard('api')->user();
                $token = $this->jwt($user);
                $this->userRepositoryInterface->update($user, ['remember_token' => $token]);
                return response()->json([
                    'success' => true,
                    'user'    => auth()->guard('api')->user(),
                    'token'   => $token
                ], 200);
            }
            throw new \Exception('Authentication failed');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    protected function jwt(User $user)
    {
        $payload = [
            'iss' => 'test', //issuer of the token
            'sub' => $user->id, //subject of the token
            'iat' => time(), //time when JWT was issued.
            'exp' => time() + 60 * 60, //time when JWT will expire
        ];
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
    
    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
    
        if (!$user) {
            return response()->json([
                'status' => 'Error',
                'message' => 'user not exist',
            ], 404);
        }
    
        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'wrong password',
            ], 400);
        }
    
        $user->token = $this->jwt($user); //
        $user->save();
        
        return response()->json([
            'status' => 'Success',
            'message' => 'successfully login',
            'data' => [
                'user' => $user,
            ]
        ], 200);
    }
}

