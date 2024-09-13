@if (Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ __('Success') }}: {!! session('success') !!}
</div>
{{ Session::forget('success') }}
@endif
@if (Session::has('error'))
<div class="alert alert-danger" role="alert">
    {{ __('Error') }}: {!! session('error') !!}
</div>
{{ Session::forget('error') }}
@endif
@if(count($errors) > 0 )
<div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <ul class="p-0 m-0">
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
