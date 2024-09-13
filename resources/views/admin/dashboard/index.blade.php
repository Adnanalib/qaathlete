@extends('admin.layouts.app')
@section('style')
<link href="{{ asset('admin/plugins/datatables/media/css/dataTables.bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css') }}"
    rel="stylesheet">
@endsection
@section('content')
<div class="row">
    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.orders')}}" class="counter">{{ $orders }}</a></h3>
                        <p class="mar-ver-5"> Total Orders</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-shopping-cart fa-3x text-info"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-info"> <span class="sr-only">60% Complete</span> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.orders.new')}}" class="counter">{{ $new_orders }}</span></h3>
                        <p class="mar-ver-5"> Total Orders(New)</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-shopping-cart fa-3x text-info"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-info"> <span class="sr-only">60% Complete</span> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.orders.in-review')}}" class="counter">{{ $in_review_orders }}</span></h3>
                        <p class="mar-ver-5"> Total Orders(In Review)</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-shopping-cart fa-3x text-info"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-info"> <span class="sr-only">60% Complete</span> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.orders.complete')}}" class="counter">{{ $completed_orders }}</span></h3>
                        <p class="mar-ver-5"> Total Order(Completed)</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-shopping-cart fa-3x text-info"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-info"> <span class="sr-only">60% Complete</span> </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.category')}}" class="counter">{{ $categories }}</span></h3>
                        <p class="mar-ver-5"> Total Categories</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-list-alt fa-3x text-secondary"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-secondary"> <span class="sr-only">60% Complete</span> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.orders.complete')}}" class="counter">{{ $earnings }}</span></h3>
                        <p class="mar-ver-5"> Earnings</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-dollar fa-3x text-secondary"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-secondary"> <span class="sr-only">60%
                            Complete</span> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.plans')}}" class="counter">{{ $active_plans }}</span></h3>
                        <p class="mar-ver-5"> Active Plans</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-tasks  fa-3x text-secondary"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-secondary"> <span class="sr-only">60%
                            Complete</span> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.products')}}" class="counter">{{ $products }}</span></h3>
                        <p class="mar-ver-5"> Total Products</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-bar-chart fa-3x text-secondary"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-secondary"> <span class="sr-only">60%
                            Complete</span> </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.teams-members')}}" class="counter">{{ $teams }}</span></h3>
                        <p class="mar-ver-5"> Total Teams</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-users fa-3x text-success"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-success"> <span class="sr-only">60%
                            Complete</span> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.teams-members')}}" class="counter">{{ $team_members }}</span></h3>
                        <p class="mar-ver-5"> Total Team Members</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-users fa-3x text-success"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-success"> <span class="sr-only">60%
                            Complete</span> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.users')}}" class="counter">{{ $users }}</span></h3>
                        <p class="mar-ver-5"> Total Users</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-user fa-3x text-success"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-success"> <span class="sr-only">60%
                            Complete</span> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.users.athlete')}}" class="counter">{{ $athletes }}</span></h3>
                        <p class="mar-ver-5"> Total Athletes</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-user fa-3x text-success"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-success"> <span class="sr-only">60%
                            Complete</span> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 eq-box-md grid">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <h3 class="mar-no"> <a href="{{route('admin.users.coach')}}" class="counter">{{ $coaches }}</span></h3>
                        <p class="mar-ver-5"> Total Coaches</p>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-2"> <i class="fa fa-user fa-3x text-success"></i> </div>
                </div>
                <div class="progress progress-striped progress-xs">
                    <div style="width: 60%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar"
                        class="progress-bar progress-bar-success"> <span class="sr-only">60%
                            Complete</span> </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.orders.table', [
    'orders' => $orderList ?? [],
    'orderTitle' => $orderTitle ?? 'Orders'
])
@endsection

@section('scripts')
<script src="{{ asset('admin/plugins/datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/media/js/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}">
</script>
<script src="{{ asset('admin/js/demo/tables-datatables.js') }}"></script>
@endsection
