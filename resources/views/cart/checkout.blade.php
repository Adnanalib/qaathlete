<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/toaster/css/lobibox.min.css') }}">
        <link type="text/css" href="{{ asset('assets/css/athlete-dashboard.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/tab.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/slick.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/google-map.css') }}" rel="stylesheet">
        <style>
            .product-detail > div {
                padding-right: 0rem;
            }
            @media (max-width: 786px) {
                .product-detail-title{
                    font-size: 45px !important;
                }
            }
        </style>
    @endpush
    <div class="w-full row">
        <div class="col-md-8">
            <p class="mb-0 dashboard-product-detail-title"><a href="{{ route('athletes.dashboard') }}"
                    class="text-decoration-none">Dashboard</a> / Your Cart</p>
            <div class="flex pt-0 product-detail-title-container">
                <a href="javascript:history.back()" class="back-button">
                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M29 22H15" stroke="#047CC0" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M22 29L15 22L22 15" stroke="#047CC0" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <rect x="1" y="1" width="42" height="42" rx="5"
                            stroke="#047CC0" stroke-width="2" />
                    </svg>
                </a>
                <p class="product-detail-title">Your Cart</p>
            </div>
        </div>
    </div>
    <div class="w-full row product-detail">
        <div class="mt-4 col-md-8">
            <p class="personal-detail">Billing Details</p>
            <form method="POST" action="javascript:void(0)" class="stripe-payment" id="payment-form">
                <div class="px-6 pt-4 register-card">
                    <div class="row">
                        <div class="mt-4 form-group form-focus col-md-12">
                            <x-input-label for="billing_address" :value="__('Billing Address')" />
                            <x-input-sublabel class="mb-4" />
                            <x-text-input id="address-input" class="block w-full" :placeholder="__('Search address')"
                                name="billing_address" :value="old('billing_address')" required />
                            <x-input-error class="mb-4" :error_key="'billing_address'" />
                            <div id="address-suggestions"></div>
                        </div>
                        <div class="stripe-payment-submit-btn-container">
                            <p class="float-right power-by-google-map">powered by Google Maps</p>
                        </div>
                    </div>
                </div>
                <p class="mt-5 personal-detail">Payment Options</p>
                <p class="auth-description">Select your payment method</p>
                @include('layouts.strip-form', ['stripeButtonText' => 'Place Order', 'hideSubmitButton' => true])
                <div class="stripe-payment-submit-btn-container">
                    <p class="power-by-stripe">powered by: Stripe</p>
                    <button type="submit" class="mt-2 btn btn-primary place-order-button">{{ __('Place Order') }}</button>
                </div>
            </form>
        </div>
    </div>
    @push('script')
        <!-- Latest compiled JavaScript -->
        <script src="https://js.stripe.com/v3/"></script>
        <script src="{{ asset('assets/js/route.js') }}"></script>
        <script src="{{ asset('plugins/toaster/js/lobibox.min.js') }}"></script>
        <script src="{{ asset('assets/js/alerts.js') }}"></script>
        <script src="{{ asset('assets/js/variable.js') }}"></script>
        <script>
            currentStripeType = 'Product';
            button.stripe.showContent = 'Wait...';
            button.stripe.hideContent = 'Place Order';
            routes.stripe.placeOrder = "{{ route('cart.placeOrder') }}";
            routes.stripe.subscription.create = "{{ route('stripe.subscription.create') }}";
            routes.stripe.subscriptionSuccess = "{{ getCurrentUserHomeUrl() }}";
        </script>
        <script src="{{ asset('assets/js/utility.js') }}"></script>
        <script src="{{ asset('assets/js/cart.js') }}"></script>
        <script src="{{ asset('assets/js/ajax.js') }}"></script>
        <script src="{{ asset('assets/js/payment.js') }}"></script>
        <script src="{{ asset('assets/js/stripe.js') }}"></script>
        <script src="{{ asset('assets/js/google-map.js') }}"></script>
        <script>
            initAutoComplete();
        </script>
    @endpush
</x-app-layout>
