<x-app-layout class="pr-f-point5">
    @push('head')
        <link type="text/css" href="{{ asset('assets/css/athlete-dashboard.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/tab.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/slick.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/modal.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/slick/slick.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/slick/slick-theme.css') }}">
        <link type="text/css" href="{{ asset('assets/css/dataTable.css') }}" rel="stylesheet">
    @endpush
    @include('layouts.alert')
    @include('coach.dashboard.header')
    <div class="w-full mt-6 dashboard-navbar">
        @if ($showAll == 'true')
            <x-setup-team :showAllTeam="$showAllTeam ?? 'true'"></x-setup-team>
        @endif
        @if ($showAllTeam == 'true')
            <x-cart-order :showAll="$showAll ?? 'true'"></x-cart-order>
        @endif
        @if ($showAll == 'false' && $showAllTeam == 'false')
            <x-product-list :route_name="'coach.product.detail'"></x-product-list>
        @endif
    </div>
    @push('script')
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="{{ asset('plugins/slick/slick.js') }}" type="text/javascript" charset="utf-8"></script>
        <script src="{{ asset('assets/js/variable.js') }}"></script>
        <script src="{{ asset('assets/js/utility.js') }}"></script>
        <script src="{{ asset('assets/js/athlete-dashboard.js') }}"></script>
        <script>
            function shouldGreaterThan(name) {
                let element = $('input[name="' + name + '"]');
                let min = parseInt(element.attr('min') ?? 0);
                if (element.val() < min) {
                    element.val(1);
                }
            }
            function downloadPdf(){

                window.open("{{route('roaster.download')}}", '_blank');
            }
        </script>
        @if ($showAll == 'true' || $showAllTeam == 'true')
            <link type="text/css" href="{{ asset('plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
            <script type="text/javascript" src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
            @if ($showAll == 'true')
                <script>
                    $('.order-table').DataTable({
                        order: [],
                        scrollX: 'true',
                    });
                </script>
            @elseif($showAllTeam == 'true')
                <script>
                    $('.setup-team-table').DataTable({
                        order: [],
                        scrollX: 'true',
                    });
                </script>
            @endif
        @endif
    @endpush
</x-app-layout>
