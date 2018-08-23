@if(Auth()->user()->role == 1)
<header class="site-header" style="background-color:#00867C;">
    <div class="container-fluid">
        <a href="{{route('dashboard')}}" class="site-logo">
            <img class="hidden-md-down" style="height:60px;width:60px;position:relative;top:-10px;left:30px;" src="{{asset('logo.png')}}" alt="">
        </a>

        <button id="show-hide-sidebar-toggle" style="top:5px;left:60px;" class="show-hide-sidebar">
            <span>toggle menu</span>
        </button>

        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>
        <div class="site-header-content">
            <div class="site-header-content-in pull-right">
                <a class="btn btn-nav btn-rounded" style="background-color:#00867C; border:none;" href="{{route('logout')}}">
                    Logout
                </a>
            </div><!--site-header-content-in-->
        </div><!--.site-header-content-->
    </div><!--.container-fluid-->
</header>
@endif

@if(Auth()->user()->role == 3)
<header class="site-header" style="background-color:#00867C;">
    <div class="container-fluid">
        <a href="{{route('h.dashboard')}}" class="site-logo">
            <img class="hidden-md-down" style="height:60px;width:60px;position:relative;top:-10px;left:30px;" src="{{asset('logo.png')}}" alt="">
        </a>

        <button id="show-hide-sidebar-toggle" style="top:5px;left:60px;" class="show-hide-sidebar">
            <span>toggle menu</span>
        </button>

        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>
        <div class="site-header-content">
            <div class="site-header-content-in pull-right">
                <a class="btn btn-nav btn-rounded" style="background-color:#00867C; border:none;" href="{{route('logout')}}">
                    Logout
                </a>
            </div><!--site-header-content-in-->
        </div><!--.site-header-content-->
    </div><!--.container-fluid-->
</header>
@endif