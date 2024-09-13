<div class="dashboard-profile-container">
    <div class="flex dashboard-title-container">
        <p class="title">Academics Details</p>
        @auth
            <a href="{{ url('/athletes/onboarding?step=1') }}" class="flex justify-end action-container">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 20H21" stroke="#047CC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M18 2.87891C17.4374 2.87891 16.8978 3.1024 16.5 3.50023L4 16.0002L3 20.0002L7 19.0002L19.5 6.50023C19.697 6.30324 19.8532 6.06939 19.9598 5.81202C20.0665 5.55465 20.1213 5.2788 20.1213 5.00023C20.1213 4.72165 20.0665 4.4458 19.9598 4.18843C19.8532 3.93106 19.697 3.69721 19.5 3.50023C19.303 3.30324 19.0692 3.14699 18.8118 3.04038C18.5544 2.93378 18.2786 2.87891 18 2.87891Z"
                        stroke="#047CC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="action">Edit Profile Details</p>
            </a>
        @endauth
    </div>
    <div class="p-0 m-0 mt-2 row pl-10px">
        <div class="col-md-6">
            <div class="nav-item-content">
                <p class="mb-1 content-title">School/College</p>
                <p class="content-description">{{ $athlete_detail->school->name ?? '-' }}</p>
            </div>
            <div class="nav-item-content mt">
                <p class="mb-1 content-title">Location</p>
                <p class="content-description">{{ $athlete_detail->state ?? '-' }}, {{ $athlete_detail->city ?? '-' }}
                </p>
            </div>
            <div class="nav-item-content mt">
                <p class="mb-1 content-title">Intended Major</p>
                <p class="content-description">{{ $athlete_detail->major_subject ?? '-' }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="nav-item-content">
                <p class="mb-1 content-title">GPA</p>
                <p class="content-description">{{ $athlete_detail->gpa ?? '-' }}</p>
            </div>
            <div class="nav-item-content mt">
                <p class="mb-1 content-title">SATs</p>
                <p class="content-description">{{ $athlete_detail->sats ?? '-' }}</p>
            </div>
            {{-- <div class="nav-item-content mt">
                <p class="mb-1 content-title">UATs</p>
                <p class="content-description">{{$athlete_detail->uats ?? '-'}}</p>
            </div> --}}
            <div class="nav-item-content mt">
                <p class="mb-1 content-title">ACT</p>
                <p class="content-description">{{ $athlete_detail->act ?? '-' }}</p>
            </div>
        </div>
    </div>
    <div class="flex mt-1 dashboard-title-container">
        <p class="title">Personal Details</p>
    </div>
    <div class="p-0 m-0 mt-2 row pl-10px">
        <div class="col-md-6">
            <div class="nav-item-content">
                <p class="mb-1 content-title">Team Name</p>
                <p class="content-description">{{ $athlete_detail->team_name ?? '-' }}</p>
            </div>
            <div class="nav-item-content mt">
                <p class="mb-1 content-title">Dominant Hand</p>
                <p class="content-description">{{ $athlete_detail->dominant_hand ?? '-' }}</p>
            </div>
            <div class="nav-item-content mt">
                <p class="mb-1 content-title">Maximum deadlift</p>
                <p class="content-description">{{ $athlete_detail->deadlift ?? '-' }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="nav-item-content">
                <p class="mb-1 content-title">Jersey Number</p>
                <p class="content-description">{{ $athlete_detail->jersey_number ?? '-' }}</p>
            </div>
            <div class="nav-item-content mt">
                <p class="mb-1 content-title">Height</p>
                <p class="content-description">{{ $athlete_detail->height ?? '-' }}</p>
            </div>
            <div class="nav-item-content mt">
                <p class="mb-1 content-title">Weight</p>
                <p class="content-description">{{ $athlete_detail->weight ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
