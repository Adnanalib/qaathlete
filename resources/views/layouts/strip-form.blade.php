@if (config('strip.paypal_enabled') == 1 || config('strip.paypal_enabled') == 'true')
<script
    src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency={{ env('CASHIER_CURRENCY') }}">
</script>
@endif
@if (auth()->user()->type == \App\Enums\UserType::COACH ||
        (auth()->user()->type == \App\Enums\UserType::ATHLETE && auth()->user()->next_plan_id != app('freePlanId')))
    <div class="px-6 py-4 register-card">
        @csrf
        <input type="hidden" name="stripe_token" />
        <input type="hidden" id="stripeCustomerId" value="{{ auth()->user()->stripe_id }}" />
        <input type="hidden" id="stripePlanId" value="" />
        <div class="error" id="card-errors" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="17"
                height="17" viewBox="0 0 17 17">
                <path class="base" fill="#000"
                    d="M8.5,17 C3.80557963,17 0,13.1944204 0,8.5 C0,3.80557963 3.80557963,0 8.5,0 C13.1944204,0 17,3.80557963 17,8.5 C17,13.1944204 13.1944204,17 8.5,17 Z">
                </path>
                <path class="glyph" fill="#FFF"
                    d="M8.5,7.29791847 L6.12604076,4.92395924 C5.79409512,4.59201359 5.25590488,4.59201359 4.92395924,4.92395924 C4.59201359,5.25590488 4.59201359,5.79409512 4.92395924,6.12604076 L7.29791847,8.5 L4.92395924,10.8739592 C4.59201359,11.2059049 4.59201359,11.7440951 4.92395924,12.0760408 C5.25590488,12.4079864 5.79409512,12.4079864 6.12604076,12.0760408 L8.5,9.70208153 L10.8739592,12.0760408 C11.2059049,12.4079864 11.7440951,12.4079864 12.0760408,12.0760408 C12.4079864,11.7440951 12.4079864,11.2059049 12.0760408,10.8739592 L9.70208153,8.5 L12.0760408,6.12604076 C12.4079864,5.79409512 12.4079864,5.25590488 12.0760408,4.92395924 C11.7440951,4.59201359 11.2059049,4.59201359 10.8739592,4.92395924 L8.5,7.29791847 L8.5,7.29791847 Z">
                </path>
            </svg>
            <span class="message"></span>
        </div>
        <div class="success">
            <div class="icon">
                <svg width="84px" height="84px" viewBox="0 0 84 84" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <circle class="border" cx="42" cy="42" r="40" stroke-linecap="round"
                        stroke-width="4" stroke="#000" fill="none"></circle>
                    <path class="checkmark" stroke-linecap="round" stroke-linejoin="round"
                        d="M23.375 42.5488281 36.8840688 56.0578969 64.891932 28.0500338" stroke-width="4"
                        stroke="#000" fill="none"></path>
                </svg>
            </div>
            <h3 class="title" data-tid="elements_examples.success.title">Payment successful</h3>
            <p class="message"><span data-tid="elements_examples.success.message">
                    Thanks for your subscription. You can now access dashboard information.
            </p>
            <a class="reset" href="#">
                <svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path fill="#000000"
                        d="M15,7.05492878 C10.5000495,7.55237307 7,11.3674463 7,16 C7,20.9705627 11.0294373,25 16,25 C20.9705627,25 25,20.9705627 25,16 C25,15.3627484 24.4834055,14.8461538 23.8461538,14.8461538 C23.2089022,14.8461538 22.6923077,15.3627484 22.6923077,16 C22.6923077,19.6960595 19.6960595,22.6923077 16,22.6923077 C12.3039405,22.6923077 9.30769231,19.6960595 9.30769231,16 C9.30769231,12.3039405 12.3039405,9.30769231 16,9.30769231 L16,12.0841673 C16,12.1800431 16.0275652,12.2738974 16.0794108,12.354546 C16.2287368,12.5868311 16.5380938,12.6540826 16.7703788,12.5047565 L22.3457501,8.92058924 L22.3457501,8.92058924 C22.4060014,8.88185624 22.4572275,8.83063012 22.4959605,8.7703788 C22.6452866,8.53809377 22.5780351,8.22873685 22.3457501,8.07941076 L22.3457501,8.07941076 L16.7703788,4.49524351 C16.6897301,4.44339794 16.5958758,4.41583275 16.5,4.41583275 C16.2238576,4.41583275 16,4.63969037 16,4.91583275 L16,7 L15,7 L15,7.05492878 Z M16,32 C7.163444,32 0,24.836556 0,16 C0,7.163444 7.163444,0 16,0 C24.836556,0 32,7.163444 32,16 C32,24.836556 24.836556,32 16,32 Z">
                    </path>
                </svg>
            </a>
        </div>
        <div class="row">
            <div class="mt-4 form-group form-focus col-md-12 display-flex">
                <div class="display-flex">
                    <x-radio-input id="master_card" class="block mt-1 mr-2 x-radio-input" name="payment_type"
                        value="1" type="radio" checked />
                    <x-input-label for="master_card" class="master_card" :value="__('Visa / Master Card')" />
                </div>
                @if (config('strip.paypal_enabled') == 1 || config('strip.paypal_enabled') == 'true')
                    <div class="display-flex master-card-type-2">
                        <x-radio-input id="pay_pal" class="block mt-1 mr-2" type="radio" name="payment_type"
                            value="2" />
                        <x-input-label for="pay_pal" class="master_card" :value="__('PayPal')" />
                    </div>
                @endif
            </div>
            <div class="form-group form-focus col-md-12">
                <hr>
            </div>
            <div id="cardPayment" class="row">
                <div class="mt-4 form-group form-focus col-md-8">
                    <x-input-label for="card_owner_name" :value="__('Card Holder Name')" />
                    <x-input-sublabel :value="__('only letters (Aa)')" />
                    <x-text-input id="stripe-card-name" class="block w-full" :placeholder="__('Card Holder Name')" name="card_owner_name"
                        :value="old('card_owner_name')" required />
                    <x-input-error class="mb-4" :error_key="'card_owner_name'" />
                </div>
                <div class="mt-4 form-group form-focus col-md-4">
                    <x-input-label for="cvv" :value="__('CVV')" />
                    <x-input-sublabel class="mb-4" />
                    <div class="block w-full mt-3 input empty x-input" id="stripe-cvv">
                    </div>
                    <x-input-error class="mb-4" :error_key="'cvv'" />
                </div>
                <div class="mt-4 form-group form-focus col-md-8">
                    <x-input-label for="card_number" :value="__('Card Number')" />
                    <x-input-sublabel :value="__('valid format 0000 - 0000 - 0000 - 0000')" />
                    <div id="stripe-card-number" class="block w-full mt-3 input empty x-input"></div>
                    <x-input-error class="mb-4" :error_key="'card_number'" />
                </div>
                <div class="mt-4 form-group form-focus col-md-4">
                    <x-input-label for="expiry" :value="__('Expiry')" />
                    <x-input-sublabel class="mb-4" />
                    <div class="block w-full mt-3 input empty x-input" id="stripe-expiry">
                    </div>
                    <x-input-error class="mb-4" :error_key="'expiry'" />
                </div>
            </div>
            <!-- Create a PayPal button -->
            <div id="paypalPayment"></div>
        </div>
    </div>
@endif
@if (!(isset($hideSubmitButton) && $hideSubmitButton == 'true'))
    <div class="stripe-payment-submit-btn-container">
        @if (auth()->user()->type == \App\Enums\UserType::ATHLETE && auth()->user()->next_plan_id == app('freePlanId'))
            <button type="button" class="mt-2 btn btn-outline-secondary place-order-button"
                onclick="window.location.href='{{ getCurrentUserHomeUrl() }}'">{{ __('Skip') }}</button>
        @else
            <p class="power-by-stripe">powered by: Stripe</p>
            <button type="submit" class="mt-2 btn btn-primary place-order-button">{{ __('Place Order') }}</button>
        @endif
    </div>
@endif
