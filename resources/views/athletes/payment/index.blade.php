<x-app-layout>
    @push('head')
    @endpush
    <div class="auth-title-container">
        <p class="auth-title">Sign Up
            <x-package-title></x-package-title>
        </p>
        <br>
        <p class="text-black personal-detail">Personal Details</p>
        <p class="auth-description ml-15px">{{ auth()->user()->full_name }}</p>
    </div>
    <div class="w-full mt-6">
        <div class="m-0 row">
            <div class="col-md-7 show-mobile">
                <x-package></x-package>
                <hr class="mb-5">
            </div>
            <div class="col-md-6">
                <p class="personal-detail">Payment Options</p>
                <p class="auth-description">Select your payment method</p>
                <form method="POST" action="javascript:void(0)" class="stripe-payment" id="payment-form">
                    @include('layouts.strip-form', [
                        'stripeButtonText' => 'Create Account',
                    ])
                </form>
            </div>
            <div class="col-md-6 show-desktop">
                <x-package></x-package>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

        @if (auth()->user()->type == \App\Enums\UserType::ATHLETE && auth()->user()->next_plan_id != app('freePlanId'))
            <script src="https://js.stripe.com/v3/"></script>
        @endif
        <script src="{{ asset('assets/js/variable.js') }}"></script>
        <script src="{{ asset('assets/js/utility.js') }}"></script>
        <script src="{{ asset('assets/js/route.js') }}"></script>
        <script>
            button.stripe.showContent = 'Wait...';
            button.stripe.hideContent = "{{ getCurrentUser()->getCurrentStep() > 1 ? 'Upgrade Package' : 'Create Account' }}";
            routes.stripe.placeOrder = "{{ route('cart.placeOrder') }}";
            routes.stripe.subscription.create = "{{ route('stripe.subscription.create') }}";
            routes.stripe.subscriptionSuccess = "{{ getCurrentUserHomeUrl() }}";
        </script>
        @if (auth()->user()->type == \App\Enums\UserType::ATHLETE && auth()->user()->next_plan_id != app('freePlanId'))
            <script src="{{ asset('assets/js/payment.js') }}"></script>
            <script src="{{ asset('assets/js/stripe.js') }}"></script>
        @endif
    @endpush
</x-app-layout>
