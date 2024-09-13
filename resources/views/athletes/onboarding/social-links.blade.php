<div class="m-0 mt-4 row">
    <div class="col-md-8">
        <p class="mb-4 personal-detail">Social Links</p>
        <form method="POST" action="{{ route('athletes.onboarding.store') }}" class="stripe-payment"
            id="onboarding-social-link-form">
            @csrf
            @if ($isUpdate == 'true' && $step == 2)
                <input type="hidden" value="4" name="_move_to_next_page">
            @endif
            @foreach ($links as $link)
                <div class="px-6 py-3 mt-3 border-none link-card">
                    <div class="row">
                        <div class="col-md-1 img-container">
                            <img
                                src="{{ !empty($link->template->icon) ? asset($link->template->icon) : asset('assets/images/links/default.png') }}" />
                        </div>
                        <div class="col-md-9">
                            <p class="link-title">{{ $link->template->title }}</p>
                            <a class="link-url" href="{{ $link->url }}">{{ $link->url }}</a>
                        </div>
                        <div class="col-md-2 action-icons-container">
                            <div class="action-icons">
                                @if ($link->is_feature == 1 || $link->is_feature == true)
                                    <img src="{{ asset('assets/images/icons/star-full.png') }}">
                                @else
                                    <img src="{{ asset('assets/images/icons/star.png') }}"
                                        title="Make this as feature link" class="link-feature-image" onclick="featureSocialLink('{{ $link->id }}')">
                                @endif
                                <img src="{{ asset('assets/images/icons/trash.svg') }}"
                                    title="Delete" onclick="deleteSocialLink('{{ $link->id }}')">
                                <img src="{{ asset('assets/images/icons/edit.svg') }}"
                                    title="Edit" onclick="editSocialLink('{{ $link->id }}','{{ $link->url }}','{{ $link->title }}','{{ $link->icon }}')">
                            </div>
                        </div>
                    </div>
                </div>
                <x-input-error class="mb-3 text-right" error_key="{{ 'social-link-' . $link->id }}" />
            @endforeach
            <div class="px-6 py-4 pb-5 mt-5 border-none register-card social-link">
                <div class="row">
                    <p class="mb-0 onboarding-form-title">
                        Social Links
                    </p>
                    <input type="hidden" name="_link_id">
                    <input type="hidden" name="_moveToNext" value="false">
                    <div class="mt-4 form-group form-focus col-md-12">
                        <x-input-label for="link" :value="__('Add link/URL')" />
                        <x-input-sublabel class="mb-3" :value="_('any social link')" />
                        <x-text-input class="block w-full" :placeholder="__('add highlight tape URL')" name="link" required />
                        <span class="x-input-right-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 13C10.4295 13.5741 10.9774 14.0491 11.6066 14.3929C12.2357 14.7367 12.9315 14.9411 13.6467 14.9923C14.3618 15.0435 15.0796 14.9403 15.7513 14.6897C16.4231 14.4392 17.0331 14.047 17.54 13.54L20.54 10.54C21.4508 9.59695 21.9548 8.33394 21.9434 7.02296C21.932 5.71198 21.4061 4.45791 20.4791 3.53087C19.5521 2.60383 18.298 2.07799 16.987 2.0666C15.676 2.0552 14.413 2.55918 13.47 3.46997L11.75 5.17997"
                                    stroke="#047CC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M14 11C13.5705 10.4259 13.0226 9.9508 12.3934 9.60704C11.7642 9.26328 11.0684 9.05886 10.3533 9.00765C9.63816 8.95643 8.92037 9.05961 8.24861 9.3102C7.57685 9.56079 6.96684 9.95291 6.45996 10.46L3.45996 13.46C2.54917 14.403 2.04519 15.666 2.05659 16.977C2.06798 18.288 2.59382 19.542 3.52086 20.4691C4.4479 21.3961 5.70197 21.922 7.01295 21.9334C8.32393 21.9447 9.58694 21.4408 10.53 20.53L12.24 18.82"
                                    stroke="#047CC0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <x-input-error class="mb-3" :error_key="'link'" />
                    </div>
                    <div class="mt-3 row">
                        <div class="mt-4 col-md-12 onboarding-btn-container">
                            <button type="submit"
                                class="ghost-btn-primary add-link-button">{{ __('Add Link') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 row">
                <div class="col-md-12 social-payment-container">
                    <p class="title">You can add {{ count($links) }}/{{ auth()->user()->getLinkLimit() }} social
                        links.</p>
                    @if (
                        !empty($nextPlan) &&
                            $nextPlan->link_limit >
                                auth()->user()->getLinkLimit())
                        @include('utility.payment', [
                            'paymentTitle' => "Need more links? Get Extra Link with $nextPlan->name + $nextPlan->link_limit links",
                            'paymentDetail' => "upgrade for $nextPlan->price",
                            'paymentUrl' => route('athletes.payment', ['plan_id' => $nextPlan->priceId]),
                        ])
                    @endif
                </div>
            </div>
            <div class="mt-3 row">
                <div class="col-md-12 onboarding-btn-container">
                    @if ($isUpdate != 'true')
                        <button type="button" onclick="previousStep(1)"
                            class="float-left ghost-btn-secondary onboarding-button previous-onboarding-btn">{{ __('Previous') }}</button>
                    @else
                        <button type="button" onclick="window.location.href='{{route('athletes.onboarding', ['step' => 1])}}'"
                            class="float-left ghost-btn-secondary onboarding-button previous-onboarding-btn">{{ __('Previous') }}</button>
                    @endif
                    <button type="button" id="social-link-btn-next"
                        class="app-btn-primary onboarding-button">{{ $isUpdate == 'true' && $step == 2 ? __('Update and Next') : __('Next') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
