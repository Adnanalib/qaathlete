@extends('admin.layouts.app')
@section('style')
<link href="{{ asset('admin/plugins/bootstrap-validator/bootstrapValidator.min.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <!-- Panel heading -->
            <div class="panel-heading">
                <h3 class="panel-title">User Profile ({{$user->email}})</h3>
            </div>
            <!-- Panel body -->
            <form id="form" class="form-horizontal" method="POST" action="{{route('admin.users.update', ['id' => $user->id])}}">
                @csrf
                @include('admin.layouts.alerts')
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-12 row text-center profile-image-container"
                        @if ($user->type == \App\Enums\UserType::ATHLETE)
                            style="background-image:url('{{ getUserBackgroundImage($user) }}')"
                        @endif
                        >
                            <img width="200" height="200" src="{{ getUserProfileImage($user) }}" alt="{{ $user->full_name ?? '' }}" class="profile-image" />
                        </div>
                        <div class="form-group col-md-6 row">
                            <label class="col-xs-3 control-label">Full Name</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="full_name"
                                    value="{{!empty($user) ? $user->full_name : ''}}" />
                            </div>
                        </div>
                        <div class="form-group col-md-6 row">
                            <label class="col-xs-3 control-label">Phone</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="phone"
                                    value="{{!empty($user) ? $user->phone : ''}}" />
                            </div>
                        </div>
                        <div class="form-group col-md-6 row">
                            <label class="col-xs-3 control-label">Password</label>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" name="password"/>
                            </div>
                        </div>
                        <div class="form-group col-md-6 row">
                            <label class="col-xs-3 control-label">Confirm Password</label>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" name="password_confirmation" />
                            </div>
                        </div>
                        @if ($user->type == \App\Enums\UserType::ATHLETE)
                            <div class="form-group col-md-6 row">
                                <label class="col-xs-3 control-label">Short Description</label>
                                <div class="col-xs-9">
                                    <textarea name="long_description" class="form-control" rows="5">{{!empty($user) ? $user->short_description : ''}}</textarea>
                                </div>
                            </div>
                            <div class="form-group col-md-6 row">
                                <label class="col-xs-3 control-label">Long Description</label>
                                <div class="col-xs-9">
                                    <textarea name="long_description" class="form-control" rows="5">{{!empty($user) ? $user->long_description : ''}}</textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info btn-lg float-right">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="{{ asset('admin/plugins/bootstrap-validator/bootstrapValidator.min.js') }}"></script>
<script>
    $('#form').bootstrapValidator({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            page_id: {
                validators: {
                    notEmpty: {
                        message: 'The Page Id is required'
                    }
                }
            },
            app_id: {
                validators: {
                    notEmpty: {
                        message: 'The App Id is required'
                    }
                }
            },
            app_secret: {
                validators: {
                    notEmpty: {
                        message: 'The App Secret is required'
                    }
                }
            },
            api_version: {
                validators: {
                    notEmpty: {
                        message: 'The Api Version is required'
                    }
                }
            },
        }
    });
</script>
@endsection
