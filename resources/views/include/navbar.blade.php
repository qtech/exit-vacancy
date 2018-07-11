<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <!--<a href="index.html" class="logo"><span>Up</span>Bond</a>-->
        <!--<a href="index.html" class="logo-sm"><span>U</span></a>-->
        <a class="logo"><img src="logo.png" height="45" width="100" alt="logo"></a>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button type="button" class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="ion-navicon"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>

                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                            <span class="profile-username">
                                Logout <span class="caret"></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                        <li><a href="{{route('logout')}}"> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>