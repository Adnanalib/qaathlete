<header class="flex">
    <div class="flex header-img-container">
        <img src="{{ asset('assets/images/header-logo-auth.png') }}" onclick="window.location.href='{{ $homeUrl }}'"
            class="cursor-pointer" alt="QC" />
    </div>
    @auth

        <div class="flex header-content-container">
            <ul class="desktop-menu">
                <li class="auth-link {{ Request::is('*/dashboard') || Request::is('athletes/onboarding') ? 'active' : '' }}">
                    <a href="{{ $homeUrl }}" class="auth-link">Home</a>
                </li>
                <li class="auth-link {{ Request::is('settings') ? 'active' : '' }}"><a href="{{ route('settings') }}"
                        class="auth-link">Settings</a></li>
                <li class="auth-link-icon cart {{ Request::is('cart/detail') ? 'active' : '' }}">
                    <a href="{{ route('cart.detail') }}" class="auth-link cart-icon">
                        <x-cart></x-cart>
                    </a>
                </li>
                <li class="auth-link-icon profile {{ Request::is('athletes/profile') ? 'active' : '' }}">
                    <span class="dropdown">
                        <img src="{{ getUserProfileImage() }}" class="profile-avatar ml-f-0">
                        <b class="full_name profile-full-name">{{ str_limit(auth()->user()->full_name, 10) }}</b>
                        <div class="dropdown-content">
                            @if (auth()->user()->type == \App\Enums\UserType::ATHLETE)
                                @if (auth()->user()->checkPermission('can-show-analytics'))
                                    <p onclick="redirectTo('{{ route('athletes.view-chart') }}', 'get')">QR Analytics</p>
                                @endif
                                <p onclick="redirectTo('{{ route('athletes.profile') }}', 'get')">Profile</p>
                            @endif
                            <p onclick="redirectTo('{{ route('logout') }}', 'post')">Logout</p>
                        </div>
                    </span>
                </li>
            </ul>
            <input type="checkbox" id="active" class="menu-options">
            <label for="active" class="menu-btn menu-options"><span></span></label>
            <label for="active" class="close menu-options"></label>
            <div class="wrapper mobile-menu">
                <ul>
                    <li><a href="{{ $homeUrl }}">Home</a></li>
                    <li><a href="{{ route('settings') }}">Settings</a></li>
                    <li><a href="{{ route('cart.detail') }}">Cart</a></li>
                    @if (auth()->user()->type == \App\Enums\UserType::ATHLETE && auth()->user()->checkPermission('can-show-analytics'))
                        <li><a href="{{ route('athletes.view-chart') }}">QR Analytics</a></li>
                    @endif
                    <li><a href="{{ route('athletes.profile') }}" class="mobile-avatar"><img src="{{ getUserProfileImage() }}"
                                class="profile-avatar"></a></li>
                    <li><a href="{{ route('athletes.profile') }}"><b >{{ auth()->user()->full_name }}</b></a></li>
                    <li><a href="javascript:void(0)" onclick="redirectTo('{{ route('logout') }}', 'post')">Logout</a></li>
                </ul>
            </div>
        </div>
    @endauth
</header>
