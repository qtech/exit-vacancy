@if(Auth()->user()->role == 1)
<div class="mobile-menu-left-overlay"></div>
	<nav class="side-menu">
	    <ul class="side-menu-list">
	        <li class="grey">
	            <a href="#">
	                <i class="font-icon font-icon-dashboard"></i>
	                <span class="lbl">Dashboard</span>
	            </a>
            </li>
            
            <li class="brown">
	            <a href="#">
	                <i class="fa fa-book"></i>
	                <span class="lbl">Booking Details</span>
	            </a>
            </li>
            
            <li class="purple">
	            <a href="{{route('appusers')}}">
	                <i class="fa fa-users"></i>
	                <span class="lbl">Application Users</span>
	            </a>
            </li>
            
            <li class="red">
	            <a href="#">
	                <i class="fa fa-building"></i>
	                <span class="lbl">Hotel Owners</span>
	            </a>
            </li>
            
            <li class="gold">
	            <a href="#">
	                <i class="fa fa-envelope"></i>
	                <span class="lbl">Send Mails</span>
	            </a>
            </li>
            
            <li class="blue-dirty">
	            <a href="#">
	                <i class="font-icon glyphicon glyphicon-send"></i>
	                <span class="lbl">Send SMS</span>
	            </a>
            </li>
            
            <li class="red">
	            <a href="{{route('notifications')}}">
	                <i class="fa fa-bell"></i>
	                <span class="lbl">User Notifications</span>
	            </a>
			</li>
			
			<li class="red">
					<a href="{{route('h.notifications')}}">
						<i class="fa fa-bell"></i>
						<span class="lbl">Hotel Notifications</span>
					</a>
				</li>
            
            <li class="magenta">
	            <a href="{{route('amenity')}}">
	                <i class="fa fa-rss"></i>
	                <span class="lbl">Hotel Amenities</span>
	            </a>
            </li>
            
            <li class="green">
	            <a href="#">
	                <i class="fa fa-bar-chart"></i>
	                <span class="lbl">Reports</span>
	            </a>
	        </li>
	    </ul>
	</nav>
@endif

@if(Auth()->user()->role == 3)
<div class="mobile-menu-left-overlay"></div>
	<nav class="side-menu">
	    <ul class="side-menu-list">
	        <li class="grey">
	            <a href="#">
	                <i class="font-icon font-icon-dashboard"></i>
	                <span class="lbl">Dashboard</span>
	            </a>
            </li>
            
            <li class="purple">
	            <a href="{{route('hotelprofile')}}">
	                <i class="font-icon glyphicon glyphicon-send"></i>
	                <span class="lbl">Profile</span>
	            </a>
			</li>
			
			<li class="brown">
				<a href="{{route('hotelbookings')}}">
					<i class="fa fa-book"></i>
					<span class="lbl">Booking Details</span>
				</a>
			</li>
            
            <li class="red with-sub">
	            <span>
	                <i class="font-icon font-icon-help"></i>
	                <span class="lbl">Rooms</span>
	            </span>
	            <ul>
	                <li><a href="{{route('h.s.room')}}"><span class="lbl">King Room</span></a></li>
	                <li><a href="{{route('h.d.room')}}"><span class="lbl">Two Queens Room</span></a></li>
	            </ul>
            </li>
            
            <li class="green">
	            <a href="#">
	                <i class="fa fa-bar-chart"></i>
	                <span class="lbl">Reports</span>
	            </a>
            </li>
	    </ul>
	</nav>
@endif