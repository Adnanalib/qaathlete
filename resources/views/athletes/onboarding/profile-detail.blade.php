<div class="m-0 mt-4 row">
    <div class="col-md-8">
        <p class="mb-4 personal-detail">Profile Details</p>
        <form method="POST" action="{{route('athletes.onboarding.store')}}" class="stripe-payment" id="onboarding-form">
            @csrf
            @if ($isUpdate == 'true' && $step == 1)
                <input type="hidden" value="2" name="_move_to_next_page">
            @endif
            <div class="px-6 py-4 pb-5 border-none register-card">
                <div class="row">
                    <p class="mb-0 onboarding-form-title">
                        Academics Details
                    </p>
                    <div class="mt-4 form-group form-focus col-md-12">
                        <x-input-label for="school" :value="__('School / College Name')" />
                        <x-input-sublabel class="mb-4" />
                        <x-select-input class="block w-full" name="school" >
                            <option value="">Select School / College Name</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}"
                                    {{ $school->id == $athlete_detail->school_id ? 'selected' : '' }}>{{ $school->name }}
                                </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error class="mb-4" :error_key="'school'" />
                    </div>
                    {{-- <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="cpa" :value="__('CPA')" />
                        <x-input-sublabel class="mb-3" :value="_('/4.0')" />
                        <x-text-input class="block w-full" :placeholder="__('3.0/4.0')" name="cpa" :value="$athlete_detail->cpa"
                             />
                        <x-input-error class="mb-4" :error_key="'cpa'" />
                    </div> --}}
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="gpa" :value="__('GPA')" />
                        <x-input-sublabel class="mb-4" :value="_('/4.0')" />
                        <x-text-input class="block w-full" :placeholder="__('3.0/4.0')" name="gpa" :value="$athlete_detail->gpa"
                             />
                        <x-input-error class="mb-4" :error_key="'gpa'" />
                    </div>
                    {{-- <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="uats" :value="__('UATs')" />
                        <x-input-sublabel class="mb-4" :value="_('/4.0')" />
                        <x-text-input class="block w-full" :placeholder="__('3.0/4.0')" name="uats" :value="$athlete_detail->uats"
                             />
                        <x-input-error class="mb-4" :error_key="'uats'" />
                    </div> --}}
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="act" :value="__('ACT')" />
                        <x-input-sublabel class="mb-4" :value="_('/4.0')" />
                        <x-text-input class="block w-full" :placeholder="__('3.0/4.0')" name="act" :value="$athlete_detail->act"
                             />
                        <x-input-error class="mb-4" :error_key="'act'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="major_subject" :value="__('Intended Major')" />
                        <x-input-sublabel class="mb-4" :value="_('course you opted as your Major')" />
                        <x-text-input class="block w-full" :placeholder="__('e.g. Maths')" name="major_subject" :value="$athlete_detail->major_subject"
                             />
                        <x-input-error class="mb-4" :error_key="'major_subject'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="sats" :value="__('SATs')" />
                        <x-input-sublabel class="mb-4" :value="_('SATs score out of 2500')" />
                        <x-text-input class="block w-full" :placeholder="__('0000/2500')" name="sats" :value="$athlete_detail->sats"
                             />
                        <x-input-error class="mb-4" :error_key="'sats'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="state" :value="__('Location')" />
                        <x-input-sublabel class="mb-4" :value="_('Your State')" />
                        <x-text-input class="block w-full" :placeholder="__('Enter your state')" name="state" :value="$athlete_detail->state"
                             />
                        <x-input-error class="mb-4" :error_key="'state'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="city" :value="__('Location')" />
                        <x-input-sublabel class="mb-4" :value="_('Your City')" />
                        <x-text-input class="block w-full" :placeholder="__('Enter your city')" name="city" :value="$athlete_detail->city"
                             />
                        <x-input-error class="mb-4" :error_key="'city'" />
                    </div>
                    {{-- <div class="mt-4 form-group form-focus col-md-12">
                        <x-input-label for="address" :value="__('Location')" />
                        <x-input-sublabel class="mb-3" :value="_('Your address')" />
                        <x-text-input class="block w-full" :placeholder="__('Grandbend Catsonville Maryland')" name="address" :value="$athlete_detail->address"
                             />
                        <x-input-error class="mb-4" :error_key="'location'" />
                    </div> --}}
                </div>
            </div>
            <div class="px-6 py-4 pb-5 mt-5 border-none register-card">
                <div class="row">
                    <p class="mb-0 onboarding-form-title">
                        Personal Details
                    </p>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="team_name" :value="__('Team Name')" />
                        <x-input-sublabel class="mb-3" :value="__('Club name if not from a school team')" />
                        <x-text-input class="block w-full" :placeholder="__('Lakers')" name="team_name" :value="$athlete_detail->team_name"
                             />
                        <x-input-error class="mb-3" :error_key="'team_name'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="jersey_no" :value="__('Jersey No')" />
                        <x-input-sublabel class="mb-3" :value="_('number behind your jersey')" />
                        <x-text-input class="block w-full" :placeholder="__('e.g. 99')" name="jersey_no" :value="$athlete_detail->jersey_number"
                             />
                        <x-input-error class="mb-3" :error_key="'jersey_no'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="dominant_hand" :value="__('Dominant Hand')" />
                        <x-input-sublabel class="mb-3" :value="_('with hand do you generally play with')" />
                        <x-text-input class="block w-full" :placeholder="__('e.g Left')" name="dominant_hand" :value="$athlete_detail->dominant_hand"
                             />
                        <x-input-error class="mb-3" :error_key="'dominant_hand'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="height" :value="__('Height')" />
                        <x-input-sublabel class="mb-3" :value="_('in ‘cm’')" />
                        <x-text-input class="block w-full" :placeholder="__('160 cm')" name="height" :value="$athlete_detail->height"
                             />
                        <x-input-error class="mb-3" :error_key="'height'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="dead_lift" :value="__('Maximun Dead Lift')" />
                        <x-input-sublabel class="mb-3" :value="_('weight in ‘pounds’')" />
                        <x-text-input class="block w-full" :placeholder="__('e.g. 200 pounds')" name="dead_lift" :value="$athlete_detail->dead_lift"
                             />
                        <x-input-error class="mb-3" :error_key="'dead_lift'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="weight" :value="__('Weight')" />
                        <x-input-sublabel class="mb-3" :value="_('in ‘pounds’')" />
                        <x-text-input class="block w-full" :placeholder="__('e.g. 140 pounds')" name="weight" :value="$athlete_detail->weight"
                             />
                        <x-input-error class="mb-3" :error_key="'weight'" />
                    </div>
                </div>
            </div>
            <div class="mt-3 row">
                <div class="col-md-12 onboarding-btn-container">
                    <button type="submit" class="app-btn-primary onboarding-button">{{$isUpdate == 'true' && $step == 1 ? __('Update and Next') :  __('Next') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
