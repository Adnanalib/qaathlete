<x-guest-layout>
    @push('head')
        <script src="{{ asset('assets/js/utility.js') }}"></script>
        <link type="text/css" href="{{ asset('assets/css/dataTable.css') }}" rel="stylesheet">
        {{-- <link type="text/css" href="{{ asset('assets/css/layout.css') }}" rel="stylesheet"> --}}
    @endpush
    <div class="onboarding-title-container">
        <p class="onboarding-title">Search Result!</p>
        <p class="auth-description">Here are some search result!</p>
    </div>
    <div class="w-full mt-6">
        <div class="m-0 mt-4 row">
            <div class="col-md-11">
                <div class="table-responsive">
                    <table class="hover order-column row-border data-table">
                        <thead>
                            <tr>
                                <th scope="col">uuid</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">QR</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script>
            $('.data-table').addClass('loading');
            $(function() {
                var dataTable = $('.data-table').DataTable({
                    "preDrawCallback": function(settings) {
                        this.api().search("{{$search}}");
                    },
                    initComplete: function(settings, json) {
                        $('.data-table').removeClass('loading');
                    },
                    lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "All"]], // Set the available page lengths: 5, 10, 15, All
                    processing: true,
                    serverSide: true,
                    order: [],
                    ajax: {
                        url: "{{ route('search-athlete-coach') }}",
                        data: function(d) {
                            d.search = $('input[type="search"]').val()
                        }
                    },
                    columns: [
                        {
                            "data": "uuid"
                        },
                        {
                            "data": "first_name"
                        },
                        {
                            "data": "last_name"
                        },
                        {
                            "data": "type"
                        },
                        {
                            "data": "qr"
                        },
                        {
                            "data": "created_at"
                        },
                        {
                            "data": "action"
                        },
                    ]
                });
            });
        </script>
    @endpush
</x-qu-layout>
