<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <!--<a href="index.html" class="logo"><span>Up</span>Bond</a>-->
        <!--<a href="index.html" class="logo-sm"><span>U</span></a>-->
        <a class="logo"><img src="{{asset('logo.png')}}" height="45" width="100" alt="logo"></a>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button type="button" class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="ion-arrow-left-c"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>

                <ul class="nav navbar-nav navbar-right pull-right">
                    <li>
                        <a href="{{route('logout')}}" class="profile waves-effect waves-light">
                            <span class="profile-username">
                                <strong>Logout </strong>
                            </span>
                        </a>    
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>