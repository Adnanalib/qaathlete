@extends('admin.layouts.app')
@section('style')
    <link href="{{ asset('admin/plugins/datatables/media/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css') }}"
        rel="stylesheet">
@endsection
@section('content')
    @include('admin.plan.table', [
        'plans' => $plans
    ])
@endsection

@section('scripts')
    <script src="{{ asset('admin/plugins/datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/media/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('admin/js/demo/tables-datatables.js') }}"></script>
@endsection
