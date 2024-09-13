@if (!empty($member->user))
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="team-roaster">
            <div class="row">
                <div class="col-4">
                    <div class="ml-1 uuid-badge">{{ $member->uuid }}</div>
                    <img class="roaster-profile-img" src="{{ getUserProfileImage($member->user) }}" />
                </div>
                <div class="col-8 z-up">
                    <div class="col-12">
                        <p class="pb-0 roaster-text">{{ str_limit($member->user->full_name, 50) }}</p>
                    </div>
                    <div class="row">
                        <div class="col-6 ml-3">
                            <p class="pb-0 roaster-text">OKC, OK</p>
                            <p class="pb-0 roaster-text">GPA: {{ $member->user->ahtlete->gpa ?? '-' }}</p>
                            <p class="pb-0 roaster-text">SS/UT</p>
                            <p class="pb-0 roaster-number">#{{ $key }}</p>
                        </div>
                        <div class="col-4">
                            <img class="roaster-qr-img" src="{{ getQRImageSrc($member->qr_image_url) }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
