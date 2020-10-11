<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Mail\ForgottenPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class PasswordsController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        if (User::where('email', $request->email)->exists()) {
            $user = User::where('email', $request->email)->first();

            $passwordsToken = [
                'email' => $user->email,
                'token' => encrypt($user->email),
                'created_at' => Carbon::now()
            ];
            if (DB::table('password_resets')->where('email', $user->email)->exists()) {
                DB::table('password_resets')->where('email', $user->email)->update($passwordsToken);
            } else {
                DB::table('password_resets')->insert($passwordsToken);
            }

            Mail::to($user->email)->send(new ForgottenPassword($user));
        }

        return responder()->success()->respond(Response::HTTP_OK);
    }

    public function resetPassword()
    {

    }

    public function hashCheck(Request $request)
    {
        //TODO 2 Hours check!
        try {
            if (DB::table('password_resets')->where('email', decrypt($request->hash))->exists()) {
                return responder()->success()->respond(Response::HTTP_OK);
            }
        } catch (\Exception $exception) {
            return responder()->error('#2607', 'Invalid Hash!')->respond(Response::HTTP_UNAUTHORIZED);
        };
    }
}
