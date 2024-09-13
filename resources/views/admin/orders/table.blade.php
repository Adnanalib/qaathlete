<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{$orderTitle}}</h3>
                <div class="table-button-container">
                    @if (isset($showButtons))
                        @if (isset($showButtons['all']) && $showButtons['all'])
                            <a href="{{route('admin.orders')}}" class="btn btn-primary" title="Orders">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="show-on-desktop">Orders</span>
                            </a>
                        @endif
                        @if (isset($showButtons[\App\Enums\OrderStatus::PENDING]) && $showButtons[\App\Enums\OrderStatus::PENDING])
                            <a href="{{route('admin.orders.new')}}" class="btn btn-warning" title="New Orders">
                                <i class="fa fa-spinner"></i>
                                <span class="show-on-desktop">New Orders</span>
                            </a>
                        @endif
                        @if (isset($showButtons[\App\Enums\OrderStatus::IN_REVIEW]) && $showButtons[\App\Enums\OrderStatus::IN_REVIEW])
                            <a href="{{route('admin.orders.in-review')}}" class="btn btn-info" title="In-Review Orders">
                                <i class="fa fa-truck"></i>
                                <span class="show-on-desktop">In-Review Orders</span>
                            </a>
                        @endif
                        @if (isset($showButtons[\App\Enums\OrderStatus::COMPLETE]) && $showButtons[\App\Enums\OrderStatus::COMPLETE])
                            <a href="{{route('admin.orders.complete')}}" class="btn btn-success" title="Complete Orders">
                                <i class="fa fa-check"></i>
                                <span class="show-on-desktop">Complete Orders</span>
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table id="demo-dt-basic" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Session Id</th>
                            <th>Billing Address</th>
                            <th>Total</th>
                            <th>Order By</th>
                            <th>Customer Name</th>
                            <th>Team Name</th>
                            <th>Status</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->sessionId }}</td>
                                <td>{{ $order->billing_address }}</td>
                                <td>$ {{ $order->grand_total }}</td>
                                <td>
                                    @if ($order->type == \App\Enums\UserType::COACH)
                                        <span class="badge badge-info">Coach</span>
                                    @elseif ($order->type == \App\Enums\UserType::ATHLETE)
                                        <span class="badge badge-success">Athlete</span>
                                    @endif
                                </td>
                                <td>{{ $order->user->full_name ?? '-' }}</td>
                                <td>{{ $order->team->name ?? '-' }}</td>
                                <td>
                                    @if ($order->status == \App\Enums\OrderStatus::PENDING)
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif ($order->status == \App\Enums\OrderStatus::IN_REVIEW)
                                        <span class="badge badge-info">In Review</span>
                                    @elseif ($order->status == \App\Enums\OrderStatus::COMPLETE)
                                        <span class="badge badge-success">Complete</span>
                                    @endif
                                </td>
                                <td>{{ !empty($order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('Y-m-d H:i:s') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
