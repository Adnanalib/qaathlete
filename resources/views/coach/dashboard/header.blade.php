<div class="w-full row">
    @php
        if (empty($user)) {
            $user = auth()->user();
        }
    @endphp
    @auth
        <div class="col-md-8">
            <div class="dashboard-title-container">
                <p class="dashboard-title coach">Welcome {{ $user->first_name }}!</p>
                <p class="dashboard-description">Tell us about your achivements</p>
            </div>
        </div>
    @endauth
    @guest
        <div class="col-md-12">
            <div class="flex dashboard-title-container profile-view-container">
                <img src="{{ getUserProfileImage() }}" class="profile-view-image" />
                <div class="profile-detail-container">
                    <p class="dashboard-title">{{ $user->full_name }}!</p>
                    @if ($user->type == \App\Enums\UserType::COACH)
                        <p class="dashboard-description">Team: </p>
                    @endif
                </div>
            </div>
        </div>
    @endguest
</div>
