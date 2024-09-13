<div class="p-0 m-0 bg-white dashboard-navbar profile-header">
    <div class="w-full m-0 row profile-header-container"
        style="background-image:url('{{ getUserBackgroundImage($user) }}')">
        @php
            if (empty($user)) {
                $user = auth()->user();
            }
        @endphp
        <img src="{{ getUserProfileImage($user) }}" class="profile-view-image" />
    </div>
    <div class="profile-detail-container">
        <p class="profile-detail-title">{{ $user->full_name }}!</p>
        @php
            $limit = 150;
            $longText = $user->short_description;
            $truncatedText = truncateText($longText, $limit);
        @endphp
        <span class="flex">
            <p id="long-text" data-long-text="{{ $longText }}" data-truncated-text="{{ $truncatedText }}">
                <span class="content-text">{{ $truncatedText }}</span>
                @if (strlen($longText) > $limit)
                    <span class="read-more">Read more</span>
                    <span class="read-less" style="display:none;">Read less</span>
                @else
                    -
                @endif
            </p>
        </span>
        <div class="flex mt-3">
            @if (!empty($user->athlete->state) || !empty($user->athlete->city))

                <span class="flex">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 23C12 23 21 17 21 10C21 7.61305 20.0518 5.32387 18.364 3.63604C16.6761 1.94821 14.3869 1 12 1C9.61305 1 7.32387 1.94821 5.63604 3.63604C3.94821 5.32387 3 7.61305 3 10C3 17 12 23 12 23Z"
                            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z"
                            stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mb-0 ml-2">{{ $user->athlete->state }}, {{ $user->athlete->city }}</p>
                </span>
            @endif
            <span class="flex ml-4 display-none">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10 13C10.4295 13.5741 10.9774 14.0491 11.6066 14.3929C12.2357 14.7367 12.9315 14.9411 13.6467 14.9923C14.3618 15.0435 15.0796 14.9403 15.7513 14.6897C16.4231 14.4392 17.0331 14.047 17.54 13.54L20.54 10.54C21.4508 9.59695 21.9548 8.33394 21.9434 7.02296C21.932 5.71198 21.4061 4.45791 20.4791 3.53087C19.5521 2.60383 18.298 2.07799 16.987 2.0666C15.676 2.0552 14.413 2.55918 13.47 3.46997L11.75 5.17997"
                        stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M14 11C13.5705 10.4259 13.0226 9.9508 12.3934 9.60704C11.7642 9.26328 11.0684 9.05886 10.3533 9.00765C9.63816 8.95643 8.92037 9.05961 8.24861 9.3102C7.57685 9.56079 6.96684 9.95291 6.45996 10.46L3.45996 13.46C2.54917 14.403 2.04519 15.666 2.05659 16.977C2.06798 18.288 2.59382 19.542 3.52086 20.4691C4.4479 21.3961 5.70197 21.922 7.01295 21.9334C8.32393 21.9447 9.58694 21.4408 10.53 20.53L12.24 18.82"
                        stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="mb-0 ml-2">{{ $user->athlete->state }}, {{ $user->athlete->city }}</p>
            </span>
            <span class="flex @if (!empty($user->athlete->state) || !empty($user->athlete->city)) ml-4 @endif">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z"
                        stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M16 2V6" stroke="black" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M8 2V6" stroke="black" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M3 10H21" stroke="black" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <p class="mb-0 ml-2">Joined {{ formatDateTime($user->athlete->created_at, 'F Y') }}</p>
            </span>
        </div>
    </div>
    @include('athletes.profile.tabs')
</div>
