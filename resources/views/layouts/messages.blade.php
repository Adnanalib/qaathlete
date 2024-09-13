@include('layouts.alert')
@if (Session::has('errors'))
    <div class="alert {{ Session::get('alert-class', 'alert-danger') }} alert-dismissible fade show alert-sm"
        role="alert">
        <ul>
            @foreach (Session::get('errors')->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
