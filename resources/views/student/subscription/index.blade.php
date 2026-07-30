@extends('layouts.app')
@section('title', 'Upgrade to Premium')
@section('page-title', 'Scholarify Premium')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Current plan banner --}}
    @if($user->isPremium())
    <div class="card p-5 bg-gradient-to-r from-yellow-50 to-amber-50 border-yellow-300">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-yellow-400 flex items-center justify-center text-xl flex-shrink-0">⭐</div>
            <div class="flex-1">
                <p class="font-bold text-yellow-900 text-lg">You are a Premium Member!</p>
                <p class="text-sm text-yellow-700">
                    Your plan is active until
                    <strong>{{ $user->plan_expires_at?->format('d F Y') ?? 'Unlimited' }}</strong>
                </p>
            </div>
            <span class="badge bg-yellow-400 text-yellow-900 text-sm px-3 py-1">✓ Active</span>
        </div>
    </div>
    @else
    {{-- Free plan current state --}}
    <div class="card p-5 bg-blue-50 border-blue-200">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-xl flex-shrink-0">🎓</div>
            <div>
                <p class="font-semibold text-blue-900">You are on the Free Plan</p>
                <p class="text-sm text-blue-700">Limited to {{ \App\Models\User::FREE_REC_LIMIT }} recommendations · Some filters locked</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Feature comparison --}}
    <div class="card overflow-hidden">
        <div class="grid grid-cols-3 divide-x divide-gray-100">
            {{-- Feature list --}}
            <div class="p-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Features</p>
                @foreach([
                    'Personalized Recommendations',
                    'University Search & Filters',
                    'Region-Based Filter',
                    'Scholarship Search',
                    'Eligible-Only Filter',
                    'Full Application Guidance',
                    'Score Breakdown Details',
                    'Unlimited Saved Applications',
                    'Deadline Email Reminders',
                    'Priority Support',
                ] as $feat)
                <p class="text-sm text-gray-600 py-2.5 border-b border-gray-50 last:border-0">{{ $feat }}</p>
                @endforeach
            </div>
            {{-- Free --}}
            <div class="p-6 bg-gray-50">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Free</p>
                @foreach(['Up to 5 only','✓','✗','✓','✗','Limited','✗','Up to 3','✗','✗'] as $v)
                <p class="text-sm py-2.5 border-b border-gray-100 last:border-0 {{ $v === '✗' ? 'text-red-400' : ($v === '✓' ? 'text-green-600 font-semibold' : 'text-gray-600') }}">
                    {{ $v }}
                </p>
                @endforeach
            </div>
            {{-- Premium --}}
            <div class="p-6 bg-gradient-to-b from-yellow-50 to-amber-50">
                <p class="text-xs font-bold text-amber-600 uppercase tracking-wide mb-4">⭐ Premium</p>
                @foreach(['Unlimited (50+)','✓','✓','✓','✓','✓','✓','Unlimited','✓','✓'] as $v)
                <p class="text-sm py-2.5 border-b border-amber-100 last:border-0 font-semibold text-green-700">{{ $v }}</p>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Pricing cards --}}
    @unless($user->isPremium())
    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-5 text-center">Choose Your Plan</h2>
        <form method="POST" action="{{ route('student.subscription.checkout') }}" id="checkoutForm">
            @csrf
            <input type="hidden" name="duration_months" id="selectedMonths" value="3">
            <input type="hidden" name="payment_method"  id="selectedMethod"  value="sslcommerz">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                @foreach($pricing as $months => $plan)
                <button type="button" onclick="selectPlan({{ $months }})"
                    id="plan-{{ $months }}"
                    class="plan-btn card p-4 text-center cursor-pointer hover:border-yellow-400 hover:shadow-md transition-all relative
                           {{ $months === 3 ? 'border-yellow-400 ring-2 ring-yellow-300 shadow-md' : '' }}">
                    @if($plan['save'])
                    <span class="absolute -top-2.5 left-1/2 -translate-x-1/2 bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                        Save {{ $plan['save'] }}
                    </span>
                    @endif
                    <p class="text-2xl font-extrabold text-gray-900">৳{{ $plan['bdt'] }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $plan['label'] }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">৳{{ round($plan['bdt']/$months) }}/mo</p>
                </button>
                @endforeach
            </div>

            {{-- Payment method --}}
            <div class="card p-5 mb-5">
                <p class="text-sm font-semibold text-gray-700 mb-3">Payment Method</p>
                <div class="grid grid-cols-3 gap-3">
                    @foreach([
                        ['id'=>'sslcommerz','label'=>'SSLCommerz','sub'=>'Card / Bank Transfer','emoji'=>'💳'],
                        ['id'=>'bkash',     'label'=>'bKash',      'sub'=>'Mobile Banking',      'emoji'=>'📱'],
                        ['id'=>'nagad',     'label'=>'Nagad',      'sub'=>'Mobile Banking',      'emoji'=>'📲'],
                    ] as $pm)
                    <button type="button" onclick="selectMethod('{{ $pm['id'] }}')"
                        id="method-{{ $pm['id'] }}"
                        class="method-btn p-4 rounded-xl border-2 text-left transition-all
                               {{ $pm['id'] === 'sslcommerz' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300' }}">
                        <p class="text-xl mb-1">{{ $pm['emoji'] }}</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $pm['label'] }}</p>
                        <p class="text-xs text-gray-500">{{ $pm['sub'] }}</p>
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- CTA --}}
            <div class="text-center">
                <button type="submit" class="inline-flex items-center gap-2 px-10 py-3.5 bg-yellow-400 text-gray-900 font-bold rounded-xl hover:bg-yellow-300 transition-colors text-base shadow-lg">
                    ⭐ Upgrade to Premium
                </button>
                <p class="text-xs text-gray-400 mt-2">Secure payment · Cancel anytime · Instant activation</p>
            </div>
        </form>
    </div>
    @endunless

    {{-- Payment history --}}
    @if($history->isNotEmpty())
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Payment History</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($history as $sub)
            <div class="px-6 py-3 flex items-center justify-between text-sm">
                <div>
                    <p class="font-medium text-gray-900">Premium · {{ $sub->duration_months }} month(s)</p>
                    <p class="text-xs text-gray-500">{{ ucfirst($sub->payment_method) }} · {{ $sub->created_at->format('d M Y') }}</p>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-900">৳{{ number_format($sub->amount_bdt) }}</p>
                    <span class="badge {{ $sub->status_badge_color }}">{{ ucfirst($sub->status) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function selectPlan(months) {
    document.getElementById('selectedMonths').value = months;
    document.querySelectorAll('.plan-btn').forEach(b => {
        b.classList.remove('border-yellow-400','ring-2','ring-yellow-300','shadow-md');
    });
    const btn = document.getElementById('plan-'+months);
    btn.classList.add('border-yellow-400','ring-2','ring-yellow-300','shadow-md');
}
function selectMethod(id) {
    document.getElementById('selectedMethod').value = id;
    document.querySelectorAll('.method-btn').forEach(b => {
        b.classList.remove('border-blue-500','bg-blue-50');
        b.classList.add('border-gray-200');
    });
    const btn = document.getElementById('method-'+id);
    btn.classList.remove('border-gray-200');
    btn.classList.add('border-blue-500','bg-blue-50');
}
</script>
@endpush
@endsection
