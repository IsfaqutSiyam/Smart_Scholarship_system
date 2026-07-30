<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $pricing = Subscription::PRICING;
        $history = $user->subscriptions()->latest('subscription_id')->take(5)->get();

        return view('student.subscription.index', compact('user', 'pricing', 'history'));
    }

    /**
     * Initiate payment — in production this calls SSLCommerz / bKash API.
     * For now we simulate a checkout page that marks the subscription paid.
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'duration_months'  => ['required', 'in:1,3,6,12'],
            'payment_method'   => ['required', 'in:sslcommerz,bkash,nagad'],
        ]);

        $months  = (int) $validated['duration_months'];
        $pricing = Subscription::PRICING[$months];
        $user    = Auth::user();

        // Create pending subscription record
        $sub = Subscription::create([
            'user_id'        => $user->user_id,
            'plan'           => 'premium',
            'duration_months'=> $months,
            'amount_bdt'     => $pricing['bdt'],
            'payment_method' => $validated['payment_method'],
            'transaction_id' => null,
            'status'         => 'pending',
        ]);

        // In production: redirect to SSLCommerz / bKash URL here
        // For demo: go to simulated payment page
        return redirect()->route('student.subscription.pay', $sub);
    }

    /**
     * Simulated payment page (replace with real gateway in production).
     */
    public function pay(Subscription $subscription)
    {
        abort_if($subscription->user_id !== Auth::id(), 403);
        return view('student.subscription.pay', compact('subscription'));
    }

    /**
     * SSLCommerz / gateway success callback — activates the subscription.
     */
    public function success(Request $request, Subscription $subscription)
    {
        abort_if($subscription->user_id !== Auth::id(), 403);

        if ($subscription->status === 'completed') {
            return redirect()->route('student.subscription.index')
                ->with('success', 'Your Premium plan is already active.');
        }

        // Mark completed
        $subscription->update([
            'status'         => 'completed',
            'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
            'starts_at'      => now(),
            'expires_at'     => now()->addMonths($subscription->duration_months),
        ]);

        // Upgrade user plan
        $subscription->user->update([
            'plan'           => 'premium',
            'plan_expires_at'=> $subscription->expires_at,
        ]);

        return redirect()->route('student.subscription.index')
            ->with('success', "🎉 You're now a Premium member! Enjoy unlimited recommendations and all filters.");
    }

    /**
     * Cancel / failed callback.
     */
    public function cancel(Subscription $subscription)
    {
        abort_if($subscription->user_id !== Auth::id(), 403);
        $subscription->update(['status' => 'cancelled']);

        return redirect()->route('student.subscription.index')
            ->with('error', 'Payment was cancelled. You can try again anytime.');
    }
}
