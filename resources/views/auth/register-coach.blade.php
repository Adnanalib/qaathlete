<x-guest-layout>
    <div class="auth-title-container coach">
        <p class="auth-title coach">Sign Up as Coach</p>
        <p class="auth-description coach mb-0">Tell us a bit about yourself</p>
        <br>
    </div>
    <div class="w-full mt-6">
        <div class="row m-0">
            <div class="col-md-8">
                @include('layouts.alert')
                <p class="personal-detail">Coach Details</p>
                <form method="POST" action="{{ route('register.coach.store') }}" id="register-form">
                    <div class="register-card px-6 py-4">
                        @csrf
                        <div class="row">
                            <p class="card-title mb-0">Personal Details</p>
                            <div class="form-group form-focus col-md-6 mt-4">
                                <x-input-label for="full_name" :value="__('Full Name')" />
                                <x-input-sublabel :value="__('only letters (Aa)')" />
                                <x-text-input class="block mt-3 w-full" type="text" :placeholder="__('Full Name')"
                                    name="full_name" :value="old('full_name')" required />
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
                                <x-text-input class="block mt-3 w-half w-full-mobile" type="phone" :placeholder="__('(816) 234 2521')"
                                    name="phone" :value="old('phone')" required />
                                <x-input-error class="mb-4" :error_key="'phone'" />
                            </div>

                            <div class="form-group form-focus col-md-6 mt-4">
                                <x-input-label for="password" :value="__('Password')" />
                                <x-input-sublabel class="mb-4" />
                                <x-text-input class="block mt-3 w-full" type="password" :placeholder="__('enter password')"
                                    name="password" :value="old('password')" required />
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
                    <div class="register-card px-6 py-4 mt-4">
                        <div class="row">
                            <p class="card-title mb-0">Club/Team Details</p>
                            <div class="form-group form-focus col-md-6 mt-4">
                                <x-input-label for="team_name" :value="__('Team Name')" />
                                <x-input-sublabel :value="__('Your club/team name')" />
                                <x-text-input class="block mt-3 w-full" type="text" :placeholder="__('i.e. Mark Tyson')"
                                    name="team_name" :value="old('team_name')" required />
                                <x-input-error class="mb-4" :error_key="'team_name'" />
                            </div>
                            <div class="form-group form-focus col-md-6 mt-4">
                                <x-input-label for="team_number" :value="__('Number of Team members')" />
                                <x-input-sublabel :value="__('How many player you have in you playing squad?')" />
                                <x-text-input class="block mt-3 w-full" type="number" :placeholder="__('e.g. 20')"
                                    name="team_number" :value="old('team_number')" required />
                                <x-input-error class="mb-4" :error_key="'team_number'" />
                            </div>
                            <div class="form-group form-focus col-md-12 mt-4">
                                <x-input-label for="sport_type" :value="__('Sports Type')" />
                                <x-input-sublabel class="mb-4" />
                                <x-select-input class="block w-full" name="sport_type" required>
                                    <option value="">Select Sports Type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $type->id == old('sport_type') ? 'selected' : '' }}>{{ $type->name }}
                                        </option>
                                    @endforeach
                                </x-select-input>
                                <x-input-error class="mb-4" :error_key="'sport_type'" />
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
        </div>
    </div>
</x-guest-layout>
