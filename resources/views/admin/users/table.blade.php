<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{$userTitle}}</h3>
                <div class="table-button-container">
                    @if (isset($showButtons))
                        @if (isset($showButtons['all']) && $showButtons['all'])
                            <a href="{{route('admin.users')}}" class="btn btn-primary" title="Users">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="show-on-desktop">Users</span>
                            </a>
                        @endif
                        @if (isset($showButtons[\App\Enums\UserType::ATHLETE]) && $showButtons[\App\Enums\UserType::ATHLETE])
                            <a href="{{route('admin.users.athlete')}}" class="btn btn-warning" title="Atheletes">
                                <i class="fa fa-users"></i>
                                <span class="show-on-desktop">Atheletes</span>
                            </a>
                        @endif
                        @if (isset($showButtons[\App\Enums\UserType::COACH]) && $showButtons[\App\Enums\UserType::COACH])
                            <a href="{{route('admin.users.coach')}}" class="btn btn-info" title="Coaches">
                                <i class="fa fa-user-secret "></i>
                                <span class="show-on-desktop">Coaches</span>
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            @include('admin.layouts.alerts')
            <div class="panel-body table-responsive">
                <table id="demo-dt-basic" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Cover Photo</th>
                            <th>Background Image</th>
                            <th>Qr Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Current Plan Name</th>
                            <th>Total Links added</th>
                            {{-- <th>Short Description</th>
                            <th>Long Description</th> --}}
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td><img width="100" height="100" src="{{ getUserProfileImage($user) }}" alt="{{ $user->full_name ?? '' }}" /></td>
                                <td><img width="100" height="100" src="{{ getUserBackgroundImage($user) }}" alt="{{ $user->full_name ?? '' }}" /></td>
                                <td><img width="100" height="100" src="{{ getQRImageSrc($user->qr_image_url) }}" alt="{{ $user->full_name ?? '' }}" /></td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    @if ($user->type == \App\Enums\UserType::COACH)
                                        <span class="badge badge-info">Coach</span>
                                    @elseif ($user->type == \App\Enums\UserType::ATHLETE)
                                        <span class="badge badge-success">Athlete</span>
                                    @endif
                                </td>
                                <td>{{ $user->plan->name ?? '-' }}</td>
                                <td>{{ $user->link_usages }}</td>
                                {{-- <td>{{ str_limit($user->short_description, 20) }}</td>
                                <td>{{ str_limit($user->long_description, 20) }}</td> --}}
                                <td>{{ !empty($user->created_at) ? \Carbon\Carbon::parse($user->created_at)->format('Y-m-d H:i:s') : '-' }}</td>
                                <td class="text-center">
                                    <a href="{{route('admin.users.edit',['id' => $user->id])}}" title="Edit User">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
