<header id="navbar">
    <div id="navbar-container" class="boxed">
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links pull-left">
                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="#"> <i class="fa fa-navicon fa-lg"></i> </a>
                </li>
            </ul>
            <ul class="nav navbar-top-links pull-right">
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="pull-right"> <img class="img-circle img-user media-object" src="{{asset('admin/img/user.png')}}"
                                alt="Profile Picture"> </span>
                        <div class="username hidden-xs">{{Auth::guard('admin')->user()->name}}</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right with-arrow">
                        <!-- User dropdown menu -->
                        <ul class="head-list">
                            <form id="logout-form" action="{{route('admin.logout')}}" method="POST">
                                @csrf

                            </form>
                            <li>
                                <a href="javascript:void(0)" onclick="$('#logout-form').submit()"> <i class="fa fa-sign-out fa-fw"></i> Logout </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
