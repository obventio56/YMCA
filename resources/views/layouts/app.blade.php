<!DOCTYPE html>
<html>
<head>
  <title>YMCA Scheduler</title>
    <!-- Styles -->
	
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/ui-lightness/jquery-ui-1.8.23.custom.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jquery.timepicker.css') }}" rel="stylesheet">
	<link href="{{ asset('js/lib/base.css') }}" rel="stylesheet">
	<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
	<link href="{{ asset('css/print.css') }}" rel="stylesheet" media="print">
	@yield('stylesheets')
</head>
<body>
	<header>
	  <div class="navbar navbar-fixed-top">
	    <div class="navbar-inner">
	      <div class="container">
	        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	        </a>
	        <a class="brand" href="/" style="color: #fff; font-weight: 700;"><img src="http://www.carlislefamilyymca.org/img/logo.png" alt=""/> <span>Carlisle Family YMCA Reservation System</span></a>
	        <div class="nav-collapse">
	          <ul class="nav pull-right">
	            @if (Auth::guest())
							<li><a href="{{ route('register') }}">Sign Up</a></li>
							@else
								@if (Auth::user()->role == 2)
									<li><a href="{{route('events-index')}}">Events & Classes</a></li>
		            	<li><a href="{{route('reservation-slots-index')}}">Reservations</a></li>
		            	<li><a href="{{route('locations-index')}}">Locations</a></li>
									<li><a href="{{route('users-index', ["admin"])}}">Admins</a></li>
		            	<li><a href="{{route('users-index', ["staff"])}}">Staff</a></li>
		            	<li><a href="{{route('users-index')}}">Members</a></li>
								@elseif (Auth::user()->role == 1)
	            		<li><a href="{{route('events-index')}}">Events & Classes</a></li>
	            		<li><a href="{{route('reservation-slots-index')}}">Reservations</a></li>
									<li><a href="{{route('users-index', ["admin"])}}">Admins</a></li>
		            	<li><a href="{{route('users-index', ["staff"])}}">Staff</a></li>
		            	<li><a href="{{route('users-index')}}">Members</a></li>
								@else
									<li><a href="{{route('events-index')}}">My Events & Classes</a></li>
			          	<li><a href="{{route('reservation-slots-index')}}">Reservations</a></li>
								@endif
	            	<li class="divider"></li>
	            	<li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello {{ Auth::user()->name }}!<b class="caret"></b></a>
		              <ul class="dropdown-menu">
										<li><a href="{{route('edit-user', [Auth::user()])}}">My Details</a></li>
		                <li class="divider"></li>
	    							<li>
											<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                         											 document.getElementById('logout-form').submit();">
                      	Sign Out
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      	{{ csrf_field() }}
											</form>
		              </ul>
		            </li>
							@endif
	          </ul>
	        </div><!-- /.nav-collapse -->
	      </div>
	    </div><!-- /navbar-inner -->
	  </div><!-- /navbar -->
	</header>

	<div id="content" class="container">
		<div id="alerts">
			@if (Session::has('status'))
			<p class="alert alert-success">{{session('status')}}</p>
			<br/><br/>
			@endif
			@if (Session::has('warning'))
			<p class="alert alert-danger">{{session('warning')}}</p>
			<br/><br/>
			@endif
		@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
		<!--
		@if (Auth::user())
			<a href="{{ URL::previous() }}" class="btn"><i class="icon-arrow-left" aria-hidden="true"></i> Go Back</a><br><br>
		@endif
		-->
		@yield('content')
    
	</div>
  <!--
  <div class="footer">
    <a href="http://www.carlislefamilyymca.org">
      Return to
        <div class="back-to-site"></div>
      
        main site
    </a>
-->
  </div>
  <script src="{{ asset('js/app.js') }}"></script> 
  <script src="{{ asset('js/jquery-1.8.0.min.js') }}"></script> 
  <script src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script> 
  <script src="{{ asset('js/jquery.timepicker.js') }}"></script> 
  <script src="{{ asset('js/lib/base.js') }}"></script> 
  <script src="{{ asset('js/jquery.datepicker.js') }}"></script> 
	
	<script type="text/javascript">
					$(document).ready(function () { 
							$('.timepicker').timepicker({
									'timeFormat': 'h:i A',
									'scrollDefaultNow': true,
									'step': 15,
									'minTime': '1:00am',
									'maxTime': '11:30pm',
							});
					});
	</script>
	
	@yield('javascript')
</body>
</html>

