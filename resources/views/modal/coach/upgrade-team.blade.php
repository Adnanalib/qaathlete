<!-- Modal -->
<div class="modal fade" id="addMore" tabindex="-1" role="dialog" aria-labelledby="teamModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-none">
                <h5 class="modal-title" id="teamModalLabel">Add more Players</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="addMoreForm" action="{{ route('coach.payment.upgrade') }}">
                @csrf
                <input type="hidden" name="isUpgrade" value=true />
                <div class="modal-body border-bottom-none">
                    <div class="mt-4 form-group form-focus">
                        <x-input-label for="player_size" :value="__('Players')" />
                        <x-input-sublabel :value="__('Enter number of players you want to add more')" />
                        <x-text-input onchange="shouldGreaterThan('player_size')" value="1" min="1"
                            class="block w-full mt-3" type="number" :placeholder="__('# of players')" name="player_size" required />
                        <x-input-error class="mb-4" :error_key="'player_size'" />
                    </div>
                </div>
                <div class="modal-footer border-top-none">
                    <button type="submit" class="btn btn-primary setup-team-next-btn">Upgrade</button>
                </div>
            </form>
        </div>
    </div>
</div>
