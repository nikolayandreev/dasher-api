<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubscriptionRequest;
use App\Models\Plans;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;

class SubscriptionsController extends Controller
{
    public function init() {
        return Auth::user()->createSetupIntent();
    }
    public function store(SubscriptionRequest $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $user = Auth::user();
            $plan = Plans::where('identifier', $request->plan)
                         ->orWhere('identifier', 'start')
                         ->first();

//            $stripeCustomer = $user->createAsStripeCustomer();

//            if ($stripeCustomer->hasDefaultPaymentMethod()) {
//                $stripeCustomer->updateDefaultPaymentMethod($request->payment_method);
//            }

            $user->newSubscription('default', $plan->stripe_id)->create($request->payment_method);

            return responder()->success(['Subscription successful, you get the course!'])->respond(Response::HTTP_OK);
        } catch (\Exception $e) {
            return responder()->error('#19922', $e->getMessage())->respond(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
