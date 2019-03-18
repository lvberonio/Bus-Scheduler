<!DOCTYPE html>
	<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
	<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
	<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
	<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>{{ trans('front/site.title') }}</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		{!! HTML::style('css/bootstrap.css') !!}
		{!! HTML::style('css/metisMenu.css') !!}
		{!! HTML::style('css/sb-admin-2.css') !!}
		{!! HTML::style('css/font-awesome.css') !!}

		<!-- Data-tables styles -->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"/>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.0/css/buttons.bootstrap.min.css"/>

		<!--[if (lt IE 9) & (!IEMobile)]>
		{!! HTML::script('js/vendor/respond.min.js') !!}
		<![endif]-->
		<!--[if lt IE 9]>
		{!! HTML::style('https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js') !!}
		{!! HTML::style('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') !!}
		<![endif]-->

		{!! HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800') !!}
		{!! HTML::style('http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic') !!}
	</head>
	<body>
		<div id="wrapper">
			<!-- Navigation -->
			<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">{{ trans('front/site.title') }}</a>
				</div>
				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown">
						@if(session('status') == 'user')
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="fa fa-user fa-fw"></i> Hi {!! auth()->user()->username !!} <i class="fa fa-caret-down"></i>
							</a>
							<ul class="dropdown-menu dropdown-user">
								<li>
									<a href="#">User Profile</a>
								</li>
								<li>
									{!! link_to('auth/logout', trans('front/site.logout')) !!}
								</li>
							</ul>
						@elseif(session('status') == 'admin')
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="fa fa-user fa-fw"></i> Hi {!! auth()->user()->role->title !!} <i class="fa fa-caret-down"></i>
							</a>
							<ul class="dropdown-menu dropdown-user">
								<li>
									<a href="{!! url('auth/logout') !!}"><span class="fa fa-fw fa-power-off"></span> {{ trans('front/site.logout') }}</a>
								</li>
							</ul>
						@else
							<li>
								{!! link_to('auth/login', trans('front/site.login')) !!}
							</li>
						@endif
					</li>
				</ul>
				<div class="navbar-default sidebar" role="navigation">
					<div class="sidebar-nav navbar-collapse">
						<ul class="nav" id="side-menu">
							@if(session('status') == 'user')
								<li>
									<a href="{!! url('locate/station') !!}"><span class="fa fa-table fa-fw"></span> {{ trans('front/site.locate') }}</a>
								</li>
							@elseif(session('status') == 'admin')
								<li>
									<a href="{!! url('bus/dashboard') !!}"><span class="fa fa-dashboard fa-fw"></span> {{ trans('front/site.dashboard') }}</a>
								</li>
								<li>
									<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> {!! trans('front/site.library') !!}<span class="fa arrow"></span></a>
									<ul class="nav nav-second-level">
										<li>
											{!! link_to('station', trans('front/site.station')) !!}
										</li>
										<li>
											{!! link_to('bus', trans('front/site.bus')) !!}
										</li>
									</ul>
								</li>
								<li>
									{!! link_to('schedule', trans('front/site.schedule')) !!}
								</li>
							@endif
						</ul>
					</div>
				</div>
			</nav>
			<div id="page-wrapper">
				<main role="main" class="container">
					@if(session()->has('ok'))
						@include('partials/error', ['type' => 'success', 'message' => session('ok')])
					@endif
					@if(isset($info))
						@include('partials/error', ['type' => 'info', 'message' => $info])
					@endif
					@yield('main')
				</main>
			</div>
		</div>
		<footer role="contentinfo">
			 @yield('footer')
			<p class="text-center"><small>Copyright &copy; Lee</small></p>
		</footer>
		{!! HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js') !!}
		<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>

		<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.bootstrap.min.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script>

		{!! HTML::script('js/bootstrap.js') !!}
		{!! HTML::script('js/metisMenu.js') !!}
		{!! HTML::script('js/sb-admin-2.js') !!}
		@yield('scripts')
	</body>
</html>