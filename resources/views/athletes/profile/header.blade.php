<div class="w-full row">
    @php
        if(empty($user)){
            $user = auth()->user();
        }
    @endphp
    @auth
        <div class="col-md-8">
            <div class="dashboard-title-container">
                <p class="dashboard-title">Hey {{ $user->first_name }}!</p>
                <p class="dashboard-description">welcome to Quickcapture dashboard</p>
            </div>
        </div>
        @if ($user->type != \App\Enums\UserType::COACH && !empty($user->qr_image_url))
            <div class="self-center col-md-4">
                <div class="flex float-right">
                    <div class="qr-links">
                        <p class="download">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15"
                                    stroke="#047CC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M7 10L12 15L17 10" stroke="#047CC0" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M12 15V3" stroke="#047CC0" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <a href="{{ route('download-qr') }}" target="_blank">Download QR code</a>
                        </p>
                        <p class="copy">
                            <span class="icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 9H11C9.89543 9 9 9.89543 9 11V20C9 21.1046 9.89543 22 11 22H20C21.1046 22 22 21.1046 22 20V11C22 9.89543 21.1046 9 20 9Z"
                                        stroke="#047CC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M5 15H4C3.46957 15 2.96086 14.7893 2.58579 14.4142C2.21071 14.0391 2 13.5304 2 13V4C2 3.46957 2.21071 2.96086 2.58579 2.58579C2.96086 2.21071 3.46957 2 4 2H13C13.5304 2 14.0391 2.21071 14.4142 2.58579C14.7893 2.96086 15 3.46957 15 4V5"
                                        stroke="#047CC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            @if ($user->qr_url)
                                <span onclick="copyLink('{{ url($user->qr_url) }}')">Copy profile link</span>
                            @endif
                        </p>
                    </div>
                    <img src="{{ getQRImageSrc($user->qr_image_url) }}" class="dashboard-athlete-qr-image">
                </div>
            </div>
        @endif
    @endauth
    @guest
        <div class="col-md-12">
            <div class="flex dashboard-title-container profile-view-container">
                <img src="{{ getUserProfileImage($user) }}" class="profile-view-image" />
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
