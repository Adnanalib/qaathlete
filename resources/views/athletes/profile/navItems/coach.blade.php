<div class="dashboard-profile-container">
    <div class="flex dashboard-title-container">
        <p class="title">Coach’s Information</p>
    </div>
    <div class="p-0 m-0 mt-2 row pl-10px">
        <div class="col-md-6">
            <div class="nav-item-content">
                <p class="mb-1 content-title">Full Name</p>
                <p class="content-description">{{$athlete_detail->coach_full_name ?? '-'}}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="nav-item-content">
                <p class="mb-1 content-title">Contact Number</p>
                <p class="content-description">{{$athlete_detail->coach_contact_info ?? '-'}}</p>
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="nav-item-content">
                <p class="mb-1 content-title">Designation</p>
                <p class="content-description">{{$athlete_detail->coach_designation ?? '-'}}</p>
            </div>
        </div> --}}
    </div>
</div>
