<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Members of Team</h3>
            </div>
            <div class="panel-body table-responsive">
                <table id="demo-dt-basic" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>UUID</th>
                            <th>QR Image</th>
                            <th>Player Name</th>
                            <th>Player Email</th>
                            <th>Invitation Status</th>
                            <th>Team Name</th>
                            <th>Jersey Size</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teamMembers as $teamMember)
                        <tr>
                            <td>{{ $teamMember->uuid }}</td>
                            <td>
                                @if ($teamMember->qr_image_url)
                                    <img width="100" height="100" src="{{ getQRImageSrc($teamMember->qr_image_url) }}" alt="{{ $teamMember->player_name ?? '' }}" />
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $teamMember->player_name ?? '-' }}</td>
                            <td>{{ $teamMember->player_email ?? '-' }}</td>
                            <td>
                                @if (!empty($teamMember->status))
                                    <span
                                        class="badge @if ($teamMember->status == \App\Enums\TeamMemberStatus::INVITATION_SENT) badge-warning @elseif($teamMember->status == \App\Enums\TeamMemberStatus::INVITATION_ACCEPTED) badge-success @endif">
                                        {{ strUcFirst(\App\Enums\TeamMemberStatus::getKey((int) $teamMember->status)) }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        Member Not Setup yet
                                    </span>
                                @endif
                            </td>
                            <td>{{ $teamMember->team->name ?? '-' }}</td>
                            <td>{{ $teamMember->size->name ?? '-' }}({{ $teamMember->size->description ?? '-' }})</td>
                            <td>{{ !empty($teamMember->created_at) ? \Carbon\Carbon::parse($teamMember->created_at)->format('Y-m-d
                                H:i:s') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
