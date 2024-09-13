@props(['showAllTeam' => true])
<div class="your-team-container">
    <div class="row coach-btn-group">
        <p class="cart-title @if ($member_count > 0) mb-1 @endif">
            Setup your team - {{ $team->name ?? '' }}
            @if ($member_count > 0)
                <button class="btn btn-primary update-team-button"
                    onclick="window.location.href='{{ route('setup.team.get') }}'">
                    <i class="fa fa-pencil"></i>
                    Update Team
                </button>
                <button class="btn btn-success update-team-button download-roaster" data-toggle="modal"
                    data-target="#roaster">
                    <i class="fa fa-download"></i>
                    Download Roaster
                </button>
            @endif
        </p>
    </div>

    <p class="no-cart">
        @if ($member_count == 0)
            Add your player in the team and make custom sports kit
            <button class="btn btn-primary setup-team-button" data-toggle="modal" data-target="#teamModal">Setup
                Team</button>
        @else
            <span class="upgrade-plan-text">You have {{ $member_count }} members in your team. Do you want to <a
                    href="javascript:void(0)" class="text-decoration-none" data-toggle="modal"
                    data-target="#addMore">add
                    more players?</a></span>
        @endif
    </p>
    @include('modal.coach.setup-team')
    @include('modal.coach.download-roaster')
    @include('modal.coach.upgrade-team')
    @if ($member_count > 0)
        <div class="mt-5 table-responsive">
            <table class="table table-hover setup-team-table">
                <thead>
                    <tr>
                        <th scope="col">Member ID</th>
                        <th scope="col">Player Name</th>
                        <th scope="col">Jersey Size</th>
                        <th scope="col">QuickCapture QR</th>
                        <th scope="col">QuickCapture profile Link</th>
                        <th scope="col">Status</th>
                        @if (config('qr.isEnabled') == 'true')
                            <th scope="col">View Chart</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $key => $member)
                        <tr>
                            <td scope="row">{{ $member->uuid ?? '-' }}</td>
                            <td>{{ $member->player_name ?? '-' }}</td>
                            <td>{{ $member->size->name ?? '-' }} ({{ $member->size->description ?? '-' }})</td>
                            <td>
                                @if (!empty($member->qr_image_url))
                                    <img src="{{ getQRImageSrc($member->qr_image_url) }}" width="50"
                                        height="50" />
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if (!empty($member->qr_url))
                                    <a href="{{ $member->qr_url }}" class="text-decoration-none"
                                        target="_blank">{{ $member->qr_url }}</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if (!empty($member->status))
                                    <span
                                        class="badge @if ($member->status == \App\Enums\TeamMemberStatus::INVITATION_SENT) badge-warning @elseif($member->status == \App\Enums\TeamMemberStatus::INVITATION_ACCEPTED) badge-success @endif">
                                        {{ strUcFirst(\App\Enums\TeamMemberStatus::getKey((int) $member->status)) }}
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        Member Not Setup yet
                                    </span>
                                @endif
                            </td>
                            @if (config('qr.isEnabled') == 'true')
                                <td>
                                    <a href="{{ route('view-chart') . '?qr_id=' . $member->qr_id }}"
                                        class="cursor-pointer" title="QR Statistics">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12 4C5 4 1 12 1 12C1 12 5 20 12 20C19 20 23 12 23 12C23 12 19 4 12 4Z"
                                                stroke="black" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                                stroke="black" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($showAllTeam == 'true' && (int) $member_count > (int) config('app.team_limit'))
                <a href="{{ getCurrentUserHomeUrl() . '?teamMemberList=true' }}"
                    class="ghost-btn-primary view-all-order">
                    {{ __('View All Team Members') }}
                </a>
            @endif
        </div>
    @endif
</div>
