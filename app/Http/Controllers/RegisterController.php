<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Interfaces\IUserRepository;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function __construct(private IUserRepository $user)
    {
        
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = $this->user->create(
            collect($request->validated())
                ->put('id', Str::uuid())
                ->put('password', bcrypt($request['password']))
                ->all()
        );
        return response()->json([
            'message' => 'user created',
            'user' => $user
        ], 200);
    }
}
