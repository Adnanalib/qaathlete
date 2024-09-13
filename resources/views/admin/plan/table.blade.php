<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Active Plans</h3>
            </div>
            <div class="panel-body table-responsive">
                <table id="demo-dt-basic" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Plan Id</th>
                            <th>Price Id</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Interval</th>
                            <th>Trial Days</th>
                            <th># of Links Allowed</th>
                            <th>Show Analytics</th>
                            <th>Plan details</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plans as $plan)
                        <tr>
                            <td>{{ $plan->id }}</td>
                            <td>{{ $plan->priceId }}</td>
                            <td>{{ $plan->name }}</td>
                            <td>{{ $plan->price }}</td>
                            <td>{{ $plan->interval }}</td>
                            <td>{{ $plan->trial }}</td>
                            <td>{{ $plan->link_limit }}</td>
                            <td>{{ $plan->show_analytics ? 'Yes' : 'No' }}</td>
                            <td>
                                @if (isset($plan->details) && count($plan->details) > 0)
                                <ul>
                                    @foreach ($plan->details as $plan_detail)
                                    <li>{{$plan_detail->description}}</li>
                                    @endforeach
                                </ul>
                                @else - @endif
                            </td>
                            <td>{{ !empty($plan->created_at) ? \Carbon\Carbon::parse($plan->created_at)->format('Y-m-d
                                H:i:s') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
