@if(Auth()->user()->role == 1)
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span><strong>Dashboard</strong></span></a>
                </li>

                <li>
                    <a href="{{route('appusers')}}" class="waves-effect"><i class="mdi mdi-account-multiple"></i><span><strong>App Users</strong></span></a>
                </li>

                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-book-open-variant"></i><span><strong>Booking Details</strong></span></a>
                </li>

                <li>
                <a href="{{route('notifications')}}" class="waves-effect"><i class="mdi mdi-notification-clear-all"></i><span><strong>Notifications</strong></span></a>
                </li>

                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-message-text-outline"></i><span><strong>Mobile SMS</strong></span></a>
                </li>

                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="mdi mdi-history"></i><span><strong>Service History</strong></span><span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="mdi mdi-check"></i><strong>Completed</strong></a></li>
                        <li><a href="#"><i class="mdi mdi-minus"></i><strong>Cancelled</strong></a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-file"></i><span><strong>Reports</strong></span></a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
@endif

@if(Auth()->user()->role == 3)
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span><strong>Dashboard</strong></span></a>
                </li>

                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-houzz"></i><span><strong>Profile</strong></span></a>
                </li>

                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="mdi mdi-hotel"></i><span><strong>Rooms</strong></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('h.s.room')}}"><strong>Standard Rooms</strong></a></li>
                        <li><a href="{{route('h.d.room')}}"><strong>Deluxe Rooms</strong></a></li>
                        <li><a href="{{route('h.sd.room')}}"><strong>Super Deluxe Rooms</strong></a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-book-open-variant"></i><span><strong>Booking Details</strong></span></a>
                </li>

                <li>
                    <a href="#" class="waves-effect"><i class="mdi mdi-file"></i><span><strong>Reports</strong></span></a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
@endif