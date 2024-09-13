<nav id="mainnav-container">
    <div class="navbar-header">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
            <div class="brand-title d-flex">
                <img src="{{asset('assets/images/logo-for-qr.jpg')}}" height="50" height="50" />
                <span class="brand-text">Admin</span>
            </div>
        </a>
    </div>
    <div id="mainnav">
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">
                    <ul id="mainnav-menu" class="list-group">
                        <!--Category name-->
                        <li class="list-header">Menu</li>
                        <li> <a href="{{ route('admin.dashboard') }}"> <i class="fa fa-home"></i> <span
                                    class="menu-title"> Dashboard </span> </a> </li>
                        <li> <a href="{{ route('admin.orders') }}"> <i class="fa fa-shopping-cart"></i> <span
                                    class="menu-title"> Orders </span> </a> </li>
                        <li> <a href="{{ route('admin.category') }}"> <i class="fa fa-list-alt"></i> <span
                                    class="menu-title"> Category </span> </a> </li>
                        <li> <a href="{{ route('admin.plans') }}"> <i class="fa fa-tasks"></i> <span
                                    class="menu-title"> Active Plans </span> </a> </li>
                        <li> <a href="{{ route('admin.products') }}"> <i class="fa fa-bar-chart"></i> <span
                                    class="menu-title"> Products </span> </a> </li>
                        <li> <a href="{{ route('admin.teams-members') }}"> <i class="fa fa-users"></i> <span
                                    class="menu-title"> Team </span> </a> </li>
                        <li> <a href="{{ route('admin.users') }}"> <i class="fa fa-user"></i> <span
                                    class="menu-title"> Users </span> </a> </li>
                        <li> <a href="{{ route('admin.profile.edit') }}"> <i class="fa fa-gear"></i> <span
                                    class="menu-title"> Profile </span> </a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
