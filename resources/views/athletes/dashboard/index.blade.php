<x-app-layout class="pr-f-0">
    @push('head')
        <link type="text/css" href="{{ asset('assets/css/athlete-dashboard.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/tab.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/slick.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/dataTable.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/slick/slick.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/slick/slick-theme.css')}}">
    @endpush
    @include('layouts.alert')
    @include('athletes.profile.header')
    <div class="w-full mt-6 dashboard-navbar">
        <x-cart-order :showAll="$showAll ?? 'true'"></x-cart-order>
        @if($showAll == 'false')
            <x-product-list :route_name="'athlete.product.detail'"></x-product-list>
        @endif
    </div>
    @push('script')
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="{{ asset('plugins/slick/slick.js') }}" type="text/javascript" charset="utf-8"></script>
        <script src="{{ asset('assets/js/utility.js') }}"></script>
        <script src="{{ asset('assets/js/athlete-dashboard.js') }}"></script>
        @if($showAll == 'true')
            <link type="text/css" href="{{ asset('plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
            <script type="text/javascript" src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
            <script>
                $('.order-table').DataTable({
                    order: [],
                    scrollX: 'true',
                });
            </script>
        @endif
    @endpush
</x-app-layoutc>
