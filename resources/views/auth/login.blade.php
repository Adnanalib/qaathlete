<x-guest-layout>
    <div class="auth-title-container">
        <p class="p-0 m-0 auth-title">Login</p>
    </div>
    <div class="flex flex-col items-center mb-4 bg-white-100 h-100">
        <div class="w-full overflow-hidden login-form-container">
            <p class="auth-description">Enter you email and password.</p>
            <form method="POST" class="login-form" action="{{ route('login') }}" id="login-form">
                @csrf
                @if (isset($_GET['uuid']))
                    <input type="hidden" name="uuid" value="{{ $_GET['uuid'] }}" />
                @endif
                <div class="row">
                    <div class="mt-4 form-group form-focus col-md-12">
                        <x-input-label for="email" :value="__('Email Address')" />
                        <x-input-sublabel :value="__('should have @ and .')" />
                        <x-text-input class="block w-full mt-3" type="email" :placeholder="__('alex@example.com')" name="email"
                            :value="old('email')" required />
                        <x-input-error class="mb-4" :error_key="'email'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-12">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-input-sublabel class="mb-4" />
                        <x-text-input class="block w-full mt-3" type="password" :placeholder="__('enter your password')" name="password"
                            :value="old('password')" required />
                        <i class="fa fa-eye-slash password-toggle"></i>
                        <x-input-error class="mb-4" :error_key="'password'" />
                    </div>
                </div>
                @if (Route::has('password.request'))
                    <div class="mt-3 mb-4 text-right reset-password">
                        {{ __('forgot password? ') }}
                        <a href="{{ route('password.request') }}">
                            {{ __('Click here') }}
                        </a>
                    </div>
                @endif
                <!-- Password -->
                <div class="mt-4">
                    <button type="submit" class="app-btn-primary login-button">{{ __('Login') }}</button>
                </div>
            </form>
            <div class="mt-3 mb-4 text-right reset-password">
                {{ __('Signup as coach? ') }}
                <a href="{{ route('register.coach') }}">
                    {{ __('Click here') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
