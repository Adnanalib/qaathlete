<x-app-layout>
    @push('head')
    @endpush
    <div class="mt-5 auth-title-container coach">
        <p class="auth-title coach">Sign Up as Coach</p>
        <p class="mb-0 auth-description coach">Tell us a bit about yourself</p>
        <br>
    </div>
    <div class="auth-title-container coach">
        <p class="personal-detail">Your Package Details</p>
        <p class="mb-0 auth-description coach">Your package according to your team size is as follow</p>
    </div>
    <div class="p-0 m-0 row">
        <div class="col-md-7">
            <div class="mt-5 coach-payment-detail">
                <div class="mb-3 row ">
                    <div class="col-md-6">
                        <p class="team_title">{{ $team->name }}</p>
                        <p class="mb-2 team__detail">
                            {{ !empty($addMorePlayerSize) ? $addMorePlayerSize : $team->total }} playing squad</p>
                        <p class="team__detail">Coach: {{ auth()->user()->full_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="team_payment_title">Monthly Subscription</p>
                        <p class="team_payment_amount">$
                            {{ auth()->user()->getCoachSubscriptionPrice($addMorePlayerSize) }} / Month</p>
                    </div>
                </div>
                @include('utility.payment', [
                    'paymentTitle' => 'Need more player? you can update player in your dashboard',
                    'paymentDetail' => '+ $' . config('strip.per_player_price') . ' per player / Month',
                ])
            </div>
        </div>
    </div>
    <div class="w-full mt-6">
        <div class="m-0 row">
            <div class="col-md-6">
                <p class="personal-detail">Payment Options</p>
                <p class="auth-description">Select your payment method</p>
                <form method="POST" action="javascript:void(0)" class="stripe-payment" id="payment-form">
                    @include('layouts.strip-form', ['stripeButtonText' => 'Create Account'])
                </form>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script src="{{ asset('assets/js/variable.js') }}"></script>
        <script src="{{ asset('assets/js/route.js') }}"></script>
        <script>
            button.stripe.showContent = 'Wait...';
            button.stripe.hideContent = 'Create Account';
            routes.stripe.placeOrder = "{{ route('cart.placeOrder') }}";
            routes.stripe.subscription.create = "{{ route('stripe.team.subscription.create') }}";
            routes.stripe.subscriptionSuccess = "{{ getCurrentUserHomeUrl() }}";
        </script>
        <script src="{{ asset('assets/js/utility.js') }}"></script>
        <script src="{{ asset('assets/js/payment.js') }}"></script>
        <script src="{{ asset('assets/js/stripe.js') }}"></script>
    @endpush
</x-app-layout>
