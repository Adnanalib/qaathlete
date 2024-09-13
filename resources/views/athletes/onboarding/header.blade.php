<div class="m-0 row">
    <div class="col-md-8">
        <div class="px-6 py-4 pb-0 border-none register-card onboarding-card">
            <div class="row">
                <div class="col-md-4">
                    <p class="flex mb-0 onboarding-card-title">
                        {{-- if it is active  --}}
                        @if ($athlete_detail->current_step == 1 || ($isUpdate == 'true' && $step == 1))
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19" stroke="#2F80ED" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @else
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19" stroke="#2E3338" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @endif
                        <span class="card-title @if ($athlete_detail->current_step == 1 || ($isUpdate == 'true' && $step == 1)) active @endif">Profile Details</span>
                    </p>
                    <ul class="onboarding-card-ul">
                        <li>Academics Details</li>
                        <li>Personal Details</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <p class="flex mb-0 onboarding-card-title">
                        {{-- if it is active  --}}
                        @if ($athlete_detail->current_step == 2 || ($isUpdate == 'true' && $step == 2))
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19" stroke="#2F80ED" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @else
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19" stroke="#2E3338" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @endif
                        <span class="card-title @if ($athlete_detail->current_step == 2 || ($isUpdate == 'true' && $step == 2)) active @endif">Social links</span>
                    </p>
                    <ul>
                        <li>Social profile links</li>
                    </ul>
                </div>
                <div class="col-md-4 display-none">
                    <p class="flex mb-0 onboarding-card-title">
                        {{-- if it is active  --}}
                        @if ($athlete_detail->current_step == 3 || ($isUpdate == 'true' && $step == 3))
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19" stroke="#2F80ED" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @else
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19" stroke="#2E3338" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @endif
                        <span class="card-title @if ($athlete_detail->current_step == 3 || ($isUpdate == 'true' && $step == 3)) active @endif">Add References</span>
                    </p>
                    <ul>
                        <li>Professor’s info</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <p class="flex mb-0 onboarding-card-title">
                        {{-- if it is active  --}}
                        @if ($athlete_detail->current_step == 4 || ($isUpdate == 'true' && $step == 4))
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19" stroke="#2F80ED" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @else
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19" stroke="#2E3338" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @endif
                        <span class="card-title @if ($athlete_detail->current_step == 4 || ($isUpdate == 'true' && $step == 4)) active @endif">Coach’s Info</span>
                    </p>
                    <ul>
                        <li>Contact info</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
