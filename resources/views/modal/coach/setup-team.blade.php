<!-- Modal -->
<div class="modal fade" id="teamModal" tabindex="-1" role="dialog" aria-labelledby="teamModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-none">
                <h5 class="modal-title" id="teamModalLabel">Team Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('setup.team') }}">
                @csrf
                <div class="modal-body border-bottom-none">
                    <div class="form-group form-focus mt-4">
                        <x-input-label for="name" :value="__('Team Name')" />
                        <x-input-sublabel :value="__('Your team name, change if you want to')" />
                        <x-text-input class="block mt-3 w-full" type="text" :placeholder="__('Enter your team name')" name="name"
                            :value="$team->name" required />
                        <x-input-error class="mb-4" :error_key="'name'" />
                    </div>
                </div>
                <div class="modal-footer border-top-none">
                    <button type="submit" class="btn btn-primary setup-team-next-btn">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>
