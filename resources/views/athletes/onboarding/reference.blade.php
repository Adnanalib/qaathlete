<div class="m-0 mt-4 row">
    <div class="col-md-8">
        <p class="mb-4 personal-detail">Add References</p>
        <form method="POST" action="{{route('athletes.onboarding.store')}}" class="stripe-payment" id="onboarding-form">
            @csrf
            @if ($isUpdate == 'true' && $step == 3)
                <input type="hidden" value="4" name="_move_to_next_page">
            @endif
            <div class="px-6 py-4 pb-5 border-none register-card">
                <div class="row">
                    <p class="mb-0 onboarding-form-title">
                        Reference Details
                    </p>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="reference_full_name" :value="__('Full Name')" />
                        <x-input-sublabel class="mb-4" :value="_('Name of your teacher or coach')" />
                        <x-text-input class="block w-full" :placeholder="__('Mr Lorrance')" name="reference_full_name" :value="$athlete_detail->reference_full_name"
                             />
                        <x-input-error class="mb-4" :error_key="'reference_full_name'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="reference_designation" :value="__('Designation')" />
                        <x-input-sublabel class="mb-4" :value="_('Title of teacher or coach i.e. head coach or assistant prof.')" />
                        <x-text-input class="block w-full" :placeholder="__('Assistant professor')" name="reference_designation" :value="$athlete_detail->reference_designation"
                             />
                        <x-input-error class="mb-4" :error_key="'reference_designation'" />
                    </div>
                    <div class="mt-4 form-group form-focus col-md-6">
                        <x-input-label for="reference_contact_info" :value="__('Contact Info')" />
                        <x-input-sublabel class="mb-4" :value="_('Valid format +1 (xxx) xxx xxxx')" />
                        <x-text-input class="block w-full" :placeholder="__('(000) 000 0000')" name="reference_contact_info" :value="$athlete_detail->reference_contact_info"
                             />
                        <x-input-error class="mb-4" :error_key="'reference_contact_info'" />
                    </div>
                </div>
            </div>
            <div class="mt-3 row">
                <div class="col-md-12 onboarding-btn-container">
                    @if ($isUpdate != 'true')
                        <button type="button" onclick="previousStep(2)"
                            class="float-left ghost-btn-secondary onboarding-button previous-onboarding-btn">{{ __('Previous') }}</button>
                    @else
                        <button type="button" onclick="window.location.href='{{route('athletes.onboarding', ['step' => 2])}}'"
                            class="float-left ghost-btn-secondary onboarding-button previous-onboarding-btn">{{ __('Previous') }}</button>
                    @endif
                    <button type="submit" class="app-btn-primary onboarding-button">{{$isUpdate == 'true' && $step == 3 ? __('Update and Next') :  __('Next') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
