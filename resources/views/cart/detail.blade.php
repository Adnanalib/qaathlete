<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/toaster/css/lobibox.min.css') }}">
        <link type="text/css" href="{{ asset('assets/css/athlete-dashboard.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/tab.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/slick.css') }}" rel="stylesheet">
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
        <div class="col-lg-8 cart-list-container">
            @if ($cart_count == 0)
                <p>No Item added in cart. Please
                    <a href="{{ getCurrentUser()->isAthlete() ? route('athletes.dashboard') : route('coach.dashboard') }}"
                        class="text-decoration-none">add some product</a> to add in cart.
                </p>
            @else
                @if (getCurrentUser()->isCoach())
                    <div class="mt-0 your-team-container">
                        <p class="mb-1 cart-title ">
                            {{$team->name}}
                        </p>
                    </div>
                    <p class="mt-4 coach-cart-padding selected-kit">Selected Kit</p>
                @endif
                @foreach ($cartItems as $cartItem)
                    <div class="mt-4 cart-item-container @if (getCurrentUser()->isCoach()) coach-cart-padding @endif">
                        <i class="fa fa-times removeItem" onclick="removeFromCart('{{ $cartItem->product->id }}')"></i>
                        <img src="{{ asset($cartItem->product->cover_photo) }}" alt="{{ $cartItem->product->title }}" />
                        <div class="cart-item-description-container">
                            @php
                                $routeName = 'athlete.product.detail';
                                if (getCurrentUser()->isCoach()) {
                                    $routeName = 'coach.product.detail';
                                }
                            @endphp
                            <p class="cursor-pointer title"
                                onclick="window.location.href='{{ route($routeName, $cartItem->product->uuid) }}'">
                                {{ str_limit($cartItem->product->title, 20, '...') }}
                            </p>
                            @if (getCurrentUser()->isAthlete())
                                <p class="description">Size: {{ $cartItem->product_variant->name }}
                                    ({{ $cartItem->product_variant->description }})
                                </p>
                            @endif
                            <p class="description">QR code on
                                {{ strUcFirst(\App\Enums\QrPreference::getKey((int) $cartItem->preference)) }}</p>
                        </div>
                        <div class="quantity-and-price-container">
                            @if (getCurrentUser()->isAthlete())
                                <p class="quantity">x<span>{{ $cartItem->quantity }}</span></p>
                            @endif
                            <p class="price @if (getCurrentUser()->isCoach()) coach-cart-padding @endif"><span>{{ $cartItem->product->currency }}
                                    {{ getCurrentUser()->isAthlete() ? $cartItem->getPrice() : $cartItem->product->price }}</span></p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        @if ($cart_count > 0)
            <div class="col-lg-4 cart-summary-container">
                <hr class="cart-vertical-hr">
                <div class="cart-summary">
                    <p class="title">Order Summary</p>
                    <br>
                    @foreach ($cartItems as $cartItem)
                        <div class="item">
                            <p>{{ str_limit($cartItem->product->title, 10, '...') }} <span
                                    class="float-right">{{ $cartItem->product->currency }}
                                    {{ getCurrentUser()->isAthlete() ? $cartItem->getPrice() : $cartItem->product->price }}</span></p>
                            @if (getCurrentUser()->isAthlete())
                                <p class="description">{{ $cartItem->product_variant->description }} • QR on
                                    {{ strUcFirst(\App\Enums\QrPreference::getKey((int) $cartItem->preference)) }}</p>
                            @elseif (getCurrentUser()->isCoach())
                            <p class="description">QR on
                                {{ strUcFirst(\App\Enums\QrPreference::getKey((int) $cartItem->preference)) }}</p>
                            <p class="pb-4">
                                <span class="float-right">({{$cartItem->quantity . 'x' . $cartItem->product->price}}) {{ $cartItem->product->currency }}
                                    {{ $cartItem->getPrice() }}</span></p>
                            @endif
                        </div>
                    @endforeach
                    <hr class="cart-summary-bottom-hr">
                    <p class="summary-titles">Shipping<span class="float-right">{{ $cartItem->product->currency }}
                            {{ $cartSummary->shipping }}</span></p>
                    <p class="summary-titles">Tax<span class="float-right">{{ $cartItem->product->currency }}
                            {{ $cartSummary->tax }}</span></p>
                    <p class="summary-titles">Discount<span class="float-right">{{ $cartItem->product->currency }}
                            {{ $cartSummary->discount }}</span></p>
                    <hr class="cart-summary-bottom-hr">
                    <p class="summary-titles">Total<span class="float-right">{{ $cartItem->product->currency }}
                            {{ $cartSummary->total }}</span></p>
                    <button type="submit" onclick="window.location.href='{{ route('cart.checkout') }}'"
                        class="app-btn-primary add-to-cart-button">{{ __('Proceed to Payment ') . $cartItem->product->currency . $cartSummary->total }}</button>
                </div>
            </div>
        @endif
    </div>
    @push('script')
        <!-- Latest compiled JavaScript -->

        <script src="{{ asset('plugins/toaster/js/lobibox.min.js') }}"></script>
        <script src="{{ asset('assets/js/alerts.js') }}"></script>
        <script src="{{ asset('assets/js/variable.js') }}"></script>
        <script src="{{ asset('assets/js/utility.js') }}"></script>
        <script src="{{ asset('assets/js/cart.js') }}"></script>
        <script src="{{ asset('assets/js/ajax.js') }}"></script>
    @endpush
</x-app-layout>
