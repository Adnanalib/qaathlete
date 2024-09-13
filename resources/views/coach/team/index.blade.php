<x-app-layout>
    @push('head')
    @endpush
    <div class="w-full row">
        <div class="col-md-8">
            <p class="mb-0 dashboard-product-detail-title"><a href="{{ route('athletes.dashboard') }}"
                    class="text-decoration-none">Dashboard</a> / Setup Team</p>
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
                <p class="setup-team-header-title">Setup {{ $team->name }}</p>
            </div>
            <p class="setup-team-header-description">Add your team players to setup the team</p>
        </div>
    </div>
    <div class="w-full mt-4 row setup-team-container">
        @if (count($teamMembers) > 0)
            <form method="POST" action="{{ route('setup.team.store') }}" class="stripe-payment" id="setup-team-form">
                @csrf
                @include('layouts.alert')
        @endif
        @foreach ($teamMembers as $key => $teamMember)
            @include('coach.team.member', [
                'key' => $key,
                'teamMember' => $teamMember,
            ])
        @endforeach
        <div class="setup-team-payment-detail">
            @include('utility.payment', [
                'paymentTitle' => 'Need more player? You can update player in your dashboard',
                'paymentDetail' => '+ $' . config('strip.per_player_price') . ' per player / Month',
            ])
        </div>
        @if (count($teamMembers) > 0)
            <div class="mt-3 row">
                <div class="col-md-10 onboarding-btn-container">
                    <button type="submit" class="app-btn-primary onboarding-button">{{ __('Update') }}</button>
                </div>
            </div>
            </form>
        @endif
    </div>
    @push('script')
        <script src="{{ asset('assets/js/utility.js') }}"></script>
        <script>
            let hideValidationError = false;
            $(function() {
                $("#setup-team-form").submit(function(event) {
                    showSpinner('#setup-team-form button', 'Wait...');
                });
            });
        </script>
    @endpush
</x-app-layout>
