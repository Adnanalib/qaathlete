<x-guest-layout>
    <div class="auth-title-container">
        <p class="auth-title">Sign Up
            <x-package-title></x-package-title>
        </p>
        <br>
    </div>
    <div class="w-full mt-6">
        <div class="row m-0">
            <div class="col-md-7 show-mobile">
                <x-package></x-package>
                <hr class="mb-5">
            </div>
            <div class="col-md-6">
                <p class="personal-detail">Personal Details</p>
                <p class="auth-description">Tell us a bit about yourself</p>
                <form method="POST" action="{{ route('register') }}" id="register-form">
                    <div class="register-card px-6 py-4">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{isset($_GET['plan_id']) ? $_GET['plan_id'] : ''}}" />
                        <div class="row">
                            <div class="form-group form-focus col-md-6 mt-4">
                                <x-input-label for="full_name" :value="__('Full Name')" />
                                <x-input-sublabel :value="__('only letters (Aa)')" />
                                <x-text-input class="block mt-3 w-full" type="text" :placeholder="__('Full Name')" name="full_name"
                                    :value="old('full_name')" required />
                                <x-input-error class="mb-4" :error_key="'full_name'" />
                            </div>
                            <div class="form-group form-focus col-md-6 mt-4">
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-input-sublabel :value="__('must contain @example.com')" />
                                <x-text-input class="block mt-3 w-full" type="email" :placeholder="__('alex@example.com')" name="email"
                                    :value="old('email')" required />
                                <x-input-error class="mb-4" :error_key="'email'" />
                            </div>

                            <div class="form-group form-focus col-md-12 mt-4">
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-input-sublabel :value="__('valid format +1 (xxx) xxx xxxx')" />
                                <x-text-input class="block mt-3 w-half w-full-mobile" type="phone" :placeholder="__('(816) 234 2521')" name="phone"
                                    :value="old('phone')" required />
                                <x-input-error class="mb-4" :error_key="'phone'" />
                            </div>

                            <div class="form-group form-focus col-md-6 mt-4">
                                <x-input-label for="password" :value="__('Password')" />
                                <x-input-sublabel class="mb-4" />
                                <x-text-input class="block mt-3 w-full" type="password" :placeholder="__('enter password')" name="password"
                                    :value="old('password')" required />
                                <i class="fa fa-eye-slash password-toggle"></i>
                                <x-input-error class="mb-4" :error_key="'password'" />
                            </div>

                            <div class="form-group form-focus col-md-6 mt-4">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-input-sublabel class="mb-4" />
                                <x-text-input class="block mt-3 w-full" type="password" :placeholder="__('re-enter password')"
                                    name="password_confirmation" :value="old('password_confirmation')" required />
                                <i class="fa fa-eye-slash password-toggle"></i>
                                <x-input-error class="mb-4" :error_key="'password_confirmation'" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 mt-4"></div>
                        <div class="col-md-3 mt-4">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Next') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 show-desktop">
                <x-package></x-package>
            </div>
        </div>
    </div>
</x-guest-layout>
