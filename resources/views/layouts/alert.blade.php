@if (Session::has('message'))
    <div class="flex alert {{ Session::get('alert-class', 'alert-info') }} {{Session::get('alert-extra-class')}} alert-dismissible fade show alert-sm"
        role="alert">
        @include('layouts.alert-icon')
        <div class="ml-2">
            @if (Session::has('alert-title'))
                <p class="mb-2 alert-title">{{ Session::get('alert-title') }}</p>
            @endif
            @if (Session::has('message'))
                <p class="mb-0 alert-message">{{ Session::get('message') }}</p>
            @endif
        </div>
    </div>
@endif
@if (Session::has('success'))
    <div class="flex alert {{ Session::get('alert-class', 'alert-info') }} {{Session::get('alert-extra-class')}} alert-dismissible fade show alert-sm"
        role="alert">
        @include('layouts.alert-icon')
        <div class="ml-2">
            @if (Session::has('alert-title'))
                <p class="mb-2 alert-title">{{ Session::get('alert-title') }}</p>
            @endif
            @if (Session::has('success'))
                <p class="mb-0 alert-message">{{ Session::get('success') }}</p>
            @endif
        </div>
    </div>
@endif
