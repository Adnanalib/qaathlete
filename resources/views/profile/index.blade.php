<x-app-layout class="p-0 m-0 grey-bg athlete-profile-container">
    @push('head')
        <link type="text/css" href="{{ asset('assets/css/athlete-dashboard.css') }}" rel="stylesheet">
        <link type="text/css" href="{{ asset('assets/css/tab.css') }}" rel="stylesheet">
        <style>
            .footer-logo-container.desktop{
                padding-left: 1rem;
                padding-right: 1rem;
                margin-top: 5px;
                border-radius: 20px 0px 0px 0px;
            }
            .footer-logo-container.mobile{
                margin-top: 20px;
                border-radius: 20px 0px 0px 0px;
            }
        </style>
    @endpush
    @include('athletes.profile.profile-header')
    <div class="w-full mt-0 bg-white dashboard-navbar profile-content-container">
        <div class="clearfix mt-1 tab-content">
            <div class="tab-pane active" id="nav-profile">
                @include('athletes.profile.navItems.profile')
            </div>
            <div class="tab-pane" id="nav-social">
                @include('athletes.profile.navItems.social')
            </div>
            <div class="tab-pane" id="nav-reference">
                @include('athletes.profile.navItems.reference')
            </div>
            <div class="tab-pane" id="nav-coach">
                @include('athletes.profile.navItems.coach')
            </div>
        </div>
    </div>
    @push('script')
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="{{ asset('assets/js/utility.js') }}"></script>
        <script src="{{ asset('assets/js/athlete-dashboard.js') }}"></script>
    @endpush
</x-app-layout>
