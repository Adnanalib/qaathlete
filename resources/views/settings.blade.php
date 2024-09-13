<x-app-layout>
    @push('head')
        <script src="{{ asset('assets/js/utility.js') }}"></script>
    @endpush
    <div class="onboarding-title-container">
        <p class="onboarding-title">Profile Settings!</p>
        <p class="auth-description">You can update your information</p>
    </div>
    <div class="w-full mt-6">
        <div class="m-0 mt-4 row">
            <div class="col-md-8">
                @include('layouts.messages')
                <form method="POST" action="{{route('update-profile')}}" class="stripe-payment" id="onboarding-form" enctype="multipart/form-data">
                    @csrf
                    <div class="px-6 py-4 pb-5 border-none register-card">
                        <div class="row">
                            <p class="mb-4 onboarding-form-title">
                                Subscription Details
                            </p>
                            @if (getCurrentUser()->isAthlete())
                                <div class="col-md-4">
                                    @include('profile.content', ['title' => 'Name','description' => getCurrentUser()->plan->name ?? '-'])
                                </div>
                                <div class="col-md-4">
                                    @include('profile.content', ['title' => 'Price','description' => getCurrentUser()->plan->currency . getCurrentUser()->plan->price ?? '$0.0'])
                                </div>
                                <div class="col-md-4">
                                    @include('profile.content', ['title' => 'Interval','description' => strUcFirst(\App\Enums\SubscriptionInterval::getKey((int) getCurrentUser()->plan->interval)) ?? '-'])
                                </div>
                                {{-- <div class="col-md-4">
                                    @include('profile.content', ['title' => 'On Trial','description' => getCurrentUser()->onTrial() ? 'Yes' : 'No'])
                                </div> --}}
                                <div class="col-md-4">
                                    @include('profile.content', ['title' => 'Remining Link Limit','description' => getCurrentUser()->getRemainingLinkLimit() ?? '-'])
                                </div>
                                <div class="col-md-4">
                                    @include('profile.content', ['title' => 'Can See Analytics','description' => getCurrentUser()->checkPermission('can-show-analytics') ? 'Yes' : 'No'])
                                </div>
                                    <div class="mt-4 col-md-12">
                                        @if (getCurrentUser()->isUpgradable())
                                            <button type="button" onclick="upgradeSubscription()" class="float-right btn btn-outline-primary">{{__('Upgrade Subscription')}}</button>
                                        @endif
                                        @if (getCurrentUser()->canCancel())
                                            <button type="button" onclick="cancelSubscription()" class="float-right mr-2 btn btn-outline-danger">{{__('Cancel Subscription')}}</button>
                                        @endif
                                    </div>

                            @elseif (getCurrentUser()->isCoach())
                                <div class="col-md-8">
                                    @include('profile.content', ['title' => 'Team Name','description' => getCurrentUser()->team->name ?? '-'])
                                </div>
                                <div class="col-md-4">
                                    @include('profile.content', ['title' => 'Total Team Members','description' => getCurrentUser()->team->getTeamMemberQuantity() ?? '0'])
                                </div>
                                <div class="col-md-8">
                                    @include('profile.content', ['title' => 'Setup Team Members','description' => getCurrentUser()->team->getSetupTeamMemberQuantity() ?? '0'])
                                </div>
                                <div class="col-md-4">
                                    @include('profile.content', ['title' => 'Non Setup Team Members','description' => getCurrentUser()->team->getNotSetupTeamMemberQuantity() ?? '0'])
                                </div>
                            @endif
                        </div>
                    </div>
                    @if (getCurrentUser()->isCoach())
                        <div class="mt-4 setup-team-payment-detail ml-f-0 mx-100">
                            @include('utility.payment', [
                                'paymentTitle' => 'Need more player? You can update player in your dashboard',
                                'paymentDetail' => '+ $' . config('strip.per_player_price') . ' per player / Month',
                            ])
                        </div>
                    @endif
                    <div class="px-6 py-4 pb-5 mt-5 border-none register-card">
                        <div class="row">
                            <p class="mb-0 onboarding-form-title">
                                Personal Details
                            </p>
                            <div class="mt-4 form-group form-focus col-md-6">
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-input-sublabel class="mb-4" :value="_('only letters (Aa)')" />
                                <x-text-input class="block w-full" :placeholder="__('Enter your first name')" name="first_name" :value="auth()->user()->first_name"
                                    required />
                                <x-input-error class="mb-4" :error_key="'first_name'" />
                            </div>
                            <div class="mt-4 form-group form-focus col-md-6">
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-input-sublabel class="mb-4" :value="_('only letters (Aa)')" />
                                <x-text-input class="block w-full" :placeholder="__('Enter your last name')" name="last_name" :value="auth()->user()->last_name"
                                     />
                                <x-input-error class="mb-4" :error_key="'last_name'" />
                            </div>
                            <div class="mt-4 form-group form-focus col-md-6">
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-input-sublabel class="mb-4" :value="_('must contain @example.com')" />
                                <x-text-input class="block w-full" :placeholder="__('alex@example.com')" name="email" :value="auth()->user()->email"
                                     disabled />
                                <x-input-error class="mb-4" :error_key="'email'" />
                            </div>
                            <div class="mt-4 form-group form-focus col-md-6">
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-input-sublabel class="mb-4" :value="_('valid format +1 (xxx) xxx xxxx')" />
                                <x-text-input class="block w-full" :placeholder="__('(816) 234 2521')" name="email" :value="auth()->user()->phone"
                                     />
                                <x-input-error class="mb-4" :error_key="'phone'" />
                            </div>

                            @if (getCurrentUser()->isAthlete())
                                <div class="mt-4 form-group form-focus col-md-6">
                                    <x-input-label for="profile_image" :value="__('Profile Photo')" />
                                    <x-input-sublabel class="mb-4" :value="_('Max file size: 2MB. Allowed types: JPG, JPEG, PNG, GIF.')" />
                                    <x-text-input class="block w-full mt-3" type="file"  accept="image/*" name="profile_image" />
                                    <x-input-error class="mb-4" :error_key="'profile_image'" />
                                </div>
                                <div class="mt-4 form-group form-focus col-md-6">
                                    <x-input-label for="background_image" :value="__('Background Photo')" />
                                    <x-input-sublabel class="mb-4" :value="_('Max file size: 2MB. Allowed types: JPG, JPEG, PNG, GIF.')" />
                                    <x-text-input class="block w-full mt-3" type="file"  accept="image/*" name="background_image" />
                                    <x-input-error class="mb-4" :error_key="'background_image'" />
                                </div>
                            @endif
                            <div class="mt-4 form-group form-focus col-md-6">
                                <x-input-label for="password" :value="__('Password')" />
                                <x-input-sublabel class="mb-4" />
                                <x-text-input class="block w-full mt-3" type="password" :placeholder="__('enter password')" name="password"
                                    :value="old('password')"  />
                                <x-input-error class="mb-4" :error_key="'password'" />
                            </div>

                            <div class="mt-4 form-group form-focus col-md-6">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-input-sublabel class="mb-4" />
                                <x-text-input class="block w-full mt-3" type="password" :placeholder="__('re-enter password')"
                                    name="password_confirmation" :value="old('password_confirmation')"  />
                                <x-input-error class="mb-4" :error_key="'password_confirmation'" />
                            </div>


                            @if (getCurrentUser()->isAthlete())
                                <div class="mt-4 form-group form-focus col-md-12">
                                    <x-input-label for="short_description" :value="__('Short Bio')" />
                                    <x-input-sublabel class="mb-4" />
                                    <x-text-input class="block w-full" :placeholder="__('Enter short description about yourself')" name="short_description" :value="auth()->user()->short_description"/>
                                    <x-input-error class="mb-4" :error_key="'short_description'" />
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3 row">
                        <div class="col-md-12 onboarding-btn-container">
                            <button type="submit" class="app-btn-primary onboarding-button">{{__('Update')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('script')
        <script src="{{ asset('assets/js/onboarding.js') }}"></script>
        <script>
            @if (getCurrentUser()->isAthlete())
                function cancelSubscription(){
                    if(confirm('Are you sure you want to delete this subscription')){
                        window.location.href = "{{route('cancel.subscription')}}"
                    }
                }
                function upgradeSubscription(){
                    window.location.href = "{{route('athletes.payment', ['plan_id' => getCurrentUser()->getNextPlan() ? getCurrentUser()->getNextPlan()->priceId : null])}}";
                }
            @endif
        </script>
    @endpush
</x-app-layout>
