<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
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
                'email'      => $user->email,
                'token'      => encrypt($user->email),
                'created_at' => Carbon::now(),
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

    public function resetPassword(ResetPasswordRequest $request)
    {
        if ($this->verifyHash($request->hash)) {
            $user           = User::where('email', decrypt($request->hash))->first();
            $user->password = $request->new_password;
            $user->save();

            $this->deleteHash($request->hash);

            return responder()->success()->respond(Response::HTTP_OK);
        }

        return responder()->error('#23211', 'Линкът е невалиден/изтекъл или вече е използван')
                          ->respond(Response::HTTP_BAD_REQUEST);
    }

    private function verifyHash($hash)
    {
        try {
            $verifiedHash = decrypt($hash);

            return $this->retrieveHash($verifiedHash);
        } catch (\Exception $exception) {
            return false;
        }
    }

    private function retrieveHash($hash)
    {
        try {
            return DB::table('password_resets')
                     ->where('email', $hash)
                     ->whereDate('created_at', '<=', Carbon::now()->subHours(2))
                     ->exists();
        } catch (\Exception $exception) {
            return false;
        }
    }

    private function deleteHash($hash)
    {
        try {
            DB::table('password_resets')
              ->where('email', decrypt($hash))
              ->delete();
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
