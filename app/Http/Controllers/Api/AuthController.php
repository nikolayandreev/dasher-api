<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegistrationRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Cashier\Exceptions\InvalidMandateException;
use Laravel\Cashier\Exceptions\PlanNotFoundException;
use Mollie\Laravel\Facades\Mollie;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::guard('web')
                ->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user              = Auth::user();
            $user->last_active = Carbon::now();
            $user->save();

            return responder()->success(Auth::user(), UserTransformer::class)->respond(Response::HTTP_OK);
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
        $user = new User($request->validated());
        $user->assignRole('manager');
        $user->save();

        try {
            $result = $user->newSubscription('main', $request->subscription)
                                 ->trialDays(14)
                                 ->create();
        } catch (InvalidMandateException $e) {
            return responder()->error('#115', 'Invalid Mandate')->respond(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (PlanNotFoundException $e) {
            return responder()->error('#117', 'Plan not Found!')->respond(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $e) {
            return responder()->error('#119', $e)->respond(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($result, 200);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json('', Response::HTTP_NO_CONTENT);
    }
}
