<x-app-layout>
    @push('head')
        <link type="text/css" href="{{ asset('assets/css/athlete-dashboard.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/tab.css') }}" rel="stylesheet">
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
    <div class="w-full row checkout-success-container">
        <div class="col-md-1">
            <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M91.6669 46.1668V50.0001C91.6617 58.9852 88.7522 67.7279 83.3724 74.9244C77.9925 82.1208 70.4305 87.3854 61.8142 89.933C53.1978 92.4806 43.9887 92.1747 35.5605 89.0609C27.1322 85.947 19.9362 80.1922 15.0458 72.6545C10.1554 65.1169 7.83263 56.2004 8.42382 47.2347C9.01501 38.2691 12.4885 29.7348 18.3263 22.9046C24.1641 16.0743 32.0534 11.3142 40.8176 9.33403C49.5818 7.35388 58.7513 8.25982 66.9585 11.9168"
                    stroke="#4D14D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M91.6667 16.667L50 58.3753L37.5 45.8753" stroke="#4D14D2" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>

        </div>
        <div class="col-md-8">
            <p class="order-place-title">Order Placed</p>
            <p class="mb-4 order-place-description">
                Your order has been places with Wooter. You can track your Order in your dashboard .
                <br>
                <br>
                Order ID: {{$order->token}}
            </p>
            <a href="{{ getCurrentUserHomeUrl() }}" class="ghost-btn-primary order-placed-go-to-dashboard">
                {{__('Go to dashboard')}}
            </a>
        </div>
    </div>
</x-app-layout>
