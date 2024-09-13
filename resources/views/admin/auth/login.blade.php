@extends('admin.layouts.auth')
@section('content')
    <div class="lock-wrapper">
        <div class="row">
            <div class="col-xs-12">
                <div class="lock-box">
                    <div class="main">
                        <h3>Admin Login</h3>
                        <div class="login-or">
                            <hr class="hr-or">
                        </div>
                        <form role="form" method="POST" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="pull-left pad-btm">
                                <div class="checkbox">
                                    <label class="form-checkbox form-icon form-text">
                                        <input type="checkbox"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div> --}}
                            <button type="submit" class="btn btn btn-primary pull-right">
                                Log In
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
