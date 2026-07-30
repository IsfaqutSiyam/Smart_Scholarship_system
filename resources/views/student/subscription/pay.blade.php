@extends('layouts.app')
@section('title', 'Complete Payment')
@section('page-title', 'Complete Payment')

@section('content')
<div class="max-w-md mx-auto space-y-5">

    {{-- Order summary --}}
    <div class="card p-6">
        <h2 class="font-bold text-gray-900 text-lg mb-4">Order Summary</h2>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Plan</span>
                <span class="font-semibold">⭐ Scholarify Premium</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Duration</span>
                <span class="font-semibold">{{ $subscription->duration_months }} Month(s)</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Payment Method</span>
                <span class="font-semibold">{{ ucfirst($subscription->payment_method) }}</span>
            </div>
            <div class="border-t border-gray-100 pt-3 flex justify-between text-base">
                <span class="font-bold text-gray-900">Total</span>
                <span class="font-bold text-gray-900">৳{{ number_format($subscription->amount_bdt) }}</span>
            </div>
        </div>
    </div>

    {{-- Demo payment simulation --}}
    <div class="card p-6 bg-yellow-50 border-yellow-200">
        <div class="flex items-start gap-3 mb-4">
            <span class="text-2xl">🧪</span>
            <div>
                <p class="font-semibold text-yellow-900">Demo Payment Mode</p>
                <p class="text-xs text-yellow-700 mt-0.5">
                    In production this page redirects to
                    {{ ucfirst($subscription->payment_method) }}'s real payment gateway.
                    Click below to simulate a successful payment.
                </p>
            </div>
        </div>

        {{-- Simulate payment gateway UI --}}
        <div class="bg-white rounded-xl border border-yellow-200 p-5 space-y-3 mb-4">
            @if($subscription->payment_method === 'sslcommerz')
            <p class="text-xs font-bold text-gray-500 uppercase">Card Details (Demo)</p>
            <div class="space-y-2">
                <input type="text" value="4111 1111 1111 1111" readonly
                       class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400 bg-gray-50">
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" value="12/28" readonly
                           class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400 bg-gray-50">
                    <input type="text" value="123" readonly
                           class="rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400 bg-gray-50">
                </div>
            </div>
            @else
            <p class="text-xs font-bold text-gray-500 uppercase">{{ ucfirst($subscription->payment_method) }} Number (Demo)</p>
            <input type="text" value="01700000000" readonly
                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400 bg-gray-50">
            <input type="text" value="1234" readonly placeholder="OTP"
                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-400 bg-gray-50">
            @endif
        </div>

        <a href="{{ route('student.subscription.success', $subscription) }}"
           class="block w-full text-center py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-colors">
            ✓ Confirm Payment — ৳{{ number_format($subscription->amount_bdt) }}
        </a>
    </div>

    <div class="flex justify-center">
        <a href="{{ route('student.subscription.cancel', $subscription) }}"
           class="text-sm text-red-500 hover:underline">Cancel & go back</a>
    </div>

    <p class="text-center text-xs text-gray-400">
        🔒 Payments are processed securely. Your financial data is never stored on our servers.
    </p>
</div>
@endsection
