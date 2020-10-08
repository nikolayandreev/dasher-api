<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegistrationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user              = Auth::user();
            $user->last_active = Carbon::now();
            $user->save();

            return responder()->success(Auth::user())->respond(Response::HTTP_OK);
        }

        throw ValidationException::withMessages([
            'credentials' => trans('auth.failed'),
        ]);
    }

    public function user()
    {
        if (Auth::check()) {
            return responder()->success(Auth::user())->respond(Response::HTTP_OK);
        }

        return responder()->error('#1001', 'Invalid session!')->respond(Response::HTTP_UNAUTHORIZED);
    }

    public function register(RegistrationRequest $request)
    {
        $user = new User($request->validated());
        $user->save();

        return responder()->success()->respond(Response::HTTP_CREATED);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}
