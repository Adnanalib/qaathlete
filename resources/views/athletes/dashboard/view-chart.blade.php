<x-app-layout class="chart-container">
    @push('head')
        <link type="text/css" href="{{ asset('assets/css/athlete-dashboard.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/tab.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/dataTable.css') }}" rel="stylesheet">
        <style>
            .setup-team-alert {
                max-width: unset;
            }
        </style>
    @endpush
    @include('layouts.alert')
    <div class="row">
        <div class="col-md-8">
            <div class="dashboard-title-container">
                <p class="dashboard-title coach">QR Detail of {{ $user->full_name }}!</p>
                <p class="dashboard-description">You will find complete detail of this QR</p>
            </div>
        </div>
        <div class="self-center col-md-4">
            <div class="flex float-right">
                <img src="{{ getQRImageSrc($user->qr_image_url) }}" class="dashboard-athlete-qr-image">
            </div>
        </div>
    </div>
    @push('script')
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="{{ asset('assets/js/variable.js') }}"></script>
        <script src="{{ asset('assets/js/utility.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
        <script>
            $('.qr-chart-table').DataTable({
                order: [],
                scrollX: 'true',
            });
        </script>
    @endpush
    @include('utility.qr-chart')
</x-app-layout>
