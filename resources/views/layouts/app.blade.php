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
	            <li><a href="{{ route('login') }}">Sign In</a></li>
							@else
	            	<li class="divider"></li>
	            	<li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello {{ Auth::user()->name }}!<b class="caret"></b></a>
		              <ul class="dropdown-menu">
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
		
		</div>
		<a href="javascript:window.print()">Print</a>
		@yield('content')
	</div>
  <script src="{{ asset('js/app.js') }}"></script> 
  <script src="{{ asset('js/jquery-1.8.0.min.js') }}"></script> 
  <script src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script> 
  <script src="{{ asset('js/jquery.timepicker.js') }}"></script> 
  <script src="{{ asset('js/lib/base.js') }}"></script> 
  <script src="{{ asset('js/jquery.datepicker.js') }}"></script> 

</body>
</html>

