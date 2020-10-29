<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegistrationRequest;
use App\Models\Plans;
use App\Models\User;
use App\Transformers\UserTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Auth::attempt($this->credentials($request), $request->remember)) {
            $token = Auth::user()->createToken($request->email)->plainTextToken;

            return response()->json(['token' => $token]);
        }

        throw ValidationException::withMessages([
            'credentials' => trans('auth.failed'),
        ]);
    }

    public function user()
    {
        if (Auth::check()) {
            return responder()->success(Auth::user(), UserTransformer::class)->respond(Response::HTTP_OK);
        }

        return responder()->error('#1001', 'Invalid session!')->respond(Response::HTTP_UNAUTHORIZED);
    }

    public function register(RegistrationRequest $request)
    {
        $user       = new User($request->validated());
        $user->type = User::TYPE_OWNER;
        $user->assignRole('manager');
        $user->save();

        return responder()->success($user, UserTransformer::class)->respond(Response::HTTP_OK);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    private function credentials($request)
    {
        return ['email' => $request->email, 'password' => $request->password];
    }
}
