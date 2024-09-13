<x-app-layout>
    @push('head')
        <link type="text/css" href="{{ asset('assets/css/athlete-dashboard.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/tab.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/slick.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/slick/slick.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/slick/slick-theme.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/magnify-image-hover/style.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/toaster/css/lobibox.min.css') }}">
    @endpush
    <div class="w-full row">
        <div class="col-md-8">
            <p class="mb-0 dashboard-product-detail-title"><a href="{{ route('athletes.dashboard') }}"
                    class="text-decoration-none">Dashboard</a> / Product Details</p>
            <div class="flex pt-0 product-detail-title-container">
                <a href="{{ route('athletes.dashboard') }}" class="back-button">
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
                <p class="product-detail-title">{{ $product->title }}</p>
            </div>
        </div>
    </div>
    <div class="w-full row product-detail">
        <div class="flex col-md-6">
            <div class="thumbnail-slider">
                @foreach ($images as $image)
                    <div><img src="{{ $image }}" alt="{{ $image }}"></div>
                @endforeach
            </div>
            <div class="product-detail-slider">
                @foreach ($images as $image)
                    <div class="container">
                        <img class="imgZoom" src="{{ $image }}" alt="{{ $image }}"
                            ref="{{ $image }}">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6 product-content-detail">
            <div class="zoom-image-container"></div>
            <p class="title">{{ $product->title }}
                <span class="float-right">{{ $product->currency }}
                    {{ count($teamMembers) * $product->getPrice() }}</span>
            </p>
            <p class="description">{{ $product->description }}</p>
            <p class="mt-4 product-variants">QR Prefernce</p>
            <div class="flex">
                <div class="qr-preference radio{{!empty($cartItem) && $cartItem->preference == \App\Enums\QrPreference::FRONT ? ' selected' : '' }}" data-value="{{\App\Enums\QrPreference::FRONT}}">
                    <input type="radio" name="qr-preference" />
                    <label>On front of Shirt</label>
                </div>
                <div class="qr-preference ml radio{{!empty($cartItem) && $cartItem->preference == \App\Enums\QrPreference::BACK ? ' selected' : '' }}" data-value="{{\App\Enums\QrPreference::BACK}}">
                    <input type="radio" name="qr-preference" />
                    <label>On back of Shirt</label>
                </div>
                <input type="hidden" name="cart-qr-preference" required value="{{$cartItem->preference ?? '' }}">
            </div>
            <span id="qr-preference-error"></span>
            <hr>
            <input type="hidden" name="product-uuid" value="{{ $product->uuid }}">
            <p class="mt-4 product-variants">Team Detail</p>
            <div class="pl-3 row">
                <div class="col-md-3">
                    <p>Team Name:</p>
                </div>
                <div class="col-md-9">
                    <span>{{ $team->name }}</span>
                </div>
                <div class="col-md-3">
                    <p>Quantity:</p>
                </div>
                <div class="col-md-9">
                    <span>{{ count($teamMembers) }}</span>
                </div>
            </div>
            <hr>
            <p class="mt-2 product-variants">Team Sizes</p>
            <div class="pl-3 row">
                @foreach ($variants as $variant)
                    <div class="col-md-3">
                        <p>{{ $variant->name }} ({{ $variant->description }}): </p>
                    </div>
                    <div class="col-md-9">
                        <span>{{ $variant->team_members_count }}</span>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="app-btn-primary add-to-cart-button">{{ __('Add to Cart') }}</button>
        </div>
    </div>

    <div class="w-full mt-6 dashboard-navbar">
        <div class="cart-list-container">
            <p class="text-black category-title">{{ __('Explore other kits') }}</p>
            @include('athletes.dashboard.list', [
                'items' => $relatedProducts,
                'route_name' => 'coach.product.detail',
            ])
        </div>
    </div>
    @push('script')
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="{{ asset('plugins/slick/slick.js') }}" type="text/javascript" charset="utf-8"></script>
        <script src="{{ asset('plugins/magnify-image-hover/script.js') }}" type="text/javascript" charset="utf-8"></script>
        <script src="{{ asset('plugins/toaster/js/lobibox.min.js') }}"></script>
        <script src="{{ asset('assets/js/alerts.js') }}"></script>
        <script src="{{ asset('assets/js/variable.js') }}"></script>
        <script src="{{ asset('assets/js/utility.js') }}"></script>
        <script src="{{ asset('assets/js/cart.js') }}"></script>
        <script src="{{ asset('assets/js/ajax.js') }}"></script>
        <script src="{{ asset('assets/js/coach-dashboard.js') }}"></script>
    @endpush
</x-app-layout>
