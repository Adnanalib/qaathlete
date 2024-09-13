<x-app-layout>
    @push('head')
        <script src="{{ asset('assets/js/utility.js') }}"></script>
    @endpush
    <div class="onboarding-title-container">
        <p class="onboarding-title">Welcome {{ auth()->user()->first_name }}!</p>
        <p class="auth-description">Tell us about your achivements</p>
    </div>
    <div class="w-full mt-6">
        @include('athletes.onboarding.header')
        @if ($athlete_detail->current_step == 1 || ($isUpdate == 'true' && $step == 1))
            @include('athletes.onboarding.profile-detail')
        @elseif($athlete_detail->current_step == 2 || ($isUpdate == 'true' && $step == 2))
            @include('athletes.onboarding.social-links')
        @elseif($athlete_detail->current_step == 3 || ($isUpdate == 'true' && $step == 3))
            @include('athletes.onboarding.reference')
        @elseif($athlete_detail->current_step == 4 || ($isUpdate == 'true' && $step == 4))
            @include('athletes.onboarding.coach')
        @endif
    </div>
    @push('script')
        <script src="{{ asset('assets/js/onboarding.js') }}"></script>
    @endpush
</x-app-layout>
