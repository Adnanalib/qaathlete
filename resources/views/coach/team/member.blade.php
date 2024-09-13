<div class="mt-2 row">
    <div class="px-6 py-4 pb-5 border-none col-md-10 register-card">
        <input type="hidden" name="uuid[]" value="{{$teamMember->uuid ?? ''}}">
        <div class="row">
            <p class="mb-0 onboarding-form-title">
                Player {{ $key + 1 }}
            </p>
            <x-input-error class="mb-4" :error_key="'uuid.*'" />
            <div class="mt-4 form-group form-focus col-md-6">
                <x-input-label for="player_name" :value="__('Player Name')" />
                <x-input-sublabel class="mb-4" :value="_('Player full name')" />
                <x-text-input class="block w-full" :placeholder="__('i.e. Mark Tyson')" name="player_name[]" :value="$teamMember->player_name ?? (old('player_name')[$key] ?? '')"  />
                <x-input-error class="mb-4" :error_key="'player_name.'.$key" />
            </div>
            <div class="mt-4 form-group form-focus col-md-6">
                <x-input-label for="jersey_size" :value="__('Jersey Size')" />
                <x-input-sublabel class="mb-4" :value="_('Select Player’s jersey size')" />
                <x-select-input class="block w-full" name="jersey_size[]" >
                    <option value="">Select Jersey Size</option>
                    @foreach ($variants as $variant)
                        <option value="{{ $variant->id }}"
                            {{ $variant->id == ($teamMember->jersey_size ?? (old('jersey_size')[$key] ?? '')) ? 'selected' : '' }}>{{ $variant->name }}
                        </option>
                    @endforeach
                </x-select-input>
                <x-input-error class="mb-4" :error_key="'jersey_size.'.$key" />
            </div>
            <div class="mt-4 form-group form-focus col-md-6">
                <x-input-label for="player_email" :value="__('Player Email')" />
                <x-input-sublabel class="mb-4" :value="_('Player Email')" />
                <x-text-input type="email" class="block w-full" :placeholder="__('example@abc.com')" name="player_email[]" :value="$teamMember->player_email ?? (old('player_email')[$key] ?? '')"  />
                <x-input-error class="mb-4" :error_key="'player_email.'.$key" />
            </div>
            <div class="mt-4 form-group form-focus col-md-12">
                <x-input-label for="profile_link" :value="__('Add link/URL')" />
                <x-input-sublabel class="mb-4" :value="_('QuickCapture profile Link')" />
                <x-text-input class="block w-full" :placeholder="__('QuickCapture Profile Link')" name="profile_link[]" :value="$teamMember->qr_url ?? (old('profile_link')[$key] ?? '')" />
                <x-input-error class="mb-4" :error_key="'profile_link.'.$key" />
            </div>
        </div>
    </div>
    <div class="col-md-2 team-qr-image-container">
        <img src="{{getQRImageSrc($teamMember->qr_image_url)}}" class="team-qr-image" />
    </div>
</div>
