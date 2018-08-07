@if(Auth()->user()->role == 1)
<div class="mobile-menu-left-overlay"></div>
	<nav class="side-menu">
	    <ul class="side-menu-list">
	        <li class="grey">
				<a href="{{route('dashboard')}}">
	                <i class="font-icon font-icon-dashboard"></i>
	                <span class="lbl">Dashboard</span>
	            </a>
            </li>
			
			<li class="brown with-sub">
				<span>
					<i class="fa fa-book"></i>
					<span class="lbl">Booking Details</span>
				</span>
				<ul>
					<li><a href="{{route('completed.bookings')}}"><span class="lbl">Completed</span></a></li>
					<li><a href="{{route('cancelled.bookings')}}"><span class="lbl">Cancelled</span></a></li>
				</ul>
			</li>
            
            <li class="purple">
	            <a href="{{route('appusers')}}">
	                <i class="fa fa-users"></i>
	                <span class="lbl">Application Users</span>
	            </a>
            </li>
            
            <li class="red">
				<a href="{{route('hotelusers')}}">
	                <i class="fa fa-building"></i>
	                <span class="lbl">Hotel Owners</span>
	            </a>
            </li>
			
			<li class="gold with-sub">
	            <span>
	                <i class="fa fa-envelope"></i>
	                <span class="lbl">Send Mails</span>
	            </span>
	            <ul>
	                <li><a href="{{route('mails')}}"><span class="lbl">Mails to Users</span></a></li>
	                <li><a href="{{route('h.mails')}}"><span class="lbl">Mails to Hotel Owners</span></a></li>
	            </ul>
			</li>
            
            <li class="blue-dirty with-sub">
	            <span>
	                <i class="fa fa-phone"></i>
	                <span class="lbl">Send SMS</span>
	            </span>
	            <ul>
	                <li><a href="{{route('sms')}}"><span class="lbl">SMS to Users</span></a></li>
	                <li><a href="{{route('h.sms')}}"><span class="lbl">SMS to Hotel Owners</span></a></li>
	            </ul>
			</li>
			
			<li class="yellow with-sub">
	            <span>
	                <i class="fa fa-bell"></i>
	                <span class="lbl">Notifications</span>
	            </span>
	            <ul>
	                <li><a href="{{route('notifications')}}"><span class="lbl">User Notifications</span></a></li>
	                <li><a href="{{route('h.notifications')}}"><span class="lbl">Hotel Notifications</span></a></li>
	            </ul>
			</li>
            
            <li class="magenta">
	            <a href="{{route('amenity')}}">
	                <i class="fa fa-rss"></i>
	                <span class="lbl">Hotel Amenities</span>
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
	            <a href="{{route('h.dashboard')}}">
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
	    </ul>
	</nav>
@endif