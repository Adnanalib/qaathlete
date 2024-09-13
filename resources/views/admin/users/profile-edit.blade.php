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
                <h3 class="panel-title">Settings</h3>
            </div>
            <!-- Panel body -->
            <form id="form" class="form-horizontal" method="POST" action="{{route('admin.profile.update')}}">
                @csrf
                @include('admin.layouts.alerts')
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-6 row">
                            <label class="col-xs-3 control-label">Name</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="name"
                                    value="{{!empty($user) ? $user->name : ''}}" />
                            </div>
                        </div>
                        <div class="form-group col-md-6 row">
                            <label class="col-xs-3 control-label">Email</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" disabled
                                    value="{{!empty($user) ? $user->email : ''}}" />
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
