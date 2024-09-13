<!-- Modal -->
<div class="modal fade" id="roaster" tabindex="-1" role="dialog" aria-labelledby="roasterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-none">
                <h5 class="modal-title" id="teamModalLabel">{{ $team->name ?? '' }} ({{ count($teamMembers) }})</h5>
                @if (count($teamMembers) > 0)
                    <button class="btn btn-success update-team-button download-roaster download-now"
                        data-toggle="tooltip" data-placement="top" title="Download Now" onclick="downloadPdf()">
                        <i class="fa fa-download"></i>
                    </button>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-bottom-none">
                <div class="form-group form-focus mt-4">
                    <div class="row">
                        @foreach ($teamMembers as $key => $member)
                            @include('coach.team.roaster-member', [
                                'member' => $member,
                                'key' => $key,
                            ])
                        @endforeach
                        @if (count($teamMembers) == 0)
                            <p class="text-center">No Active Members found yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script></script>
