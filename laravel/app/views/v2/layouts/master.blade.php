<!DOCTYPE html>

<?php

	$have_user = Auth::check();
	$is_mod = Session::get('mod');
	$is_admin = Session::get('admin');
	$is_mobile = Agent::isMobile();

?>

<html ng-app>
  <head>
    <title>@yield('title','Two Thousand Times')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="{{Config::get('app.staticurl')}}/css/animate.css" rel="stylesheet" media="screen">
    
	<link href="{{Config::get('app.staticurl')}}/css/compiled/v2/bs.css" rel="stylesheet" media="screen">

    <!--Application Shared CSS-->
    <link href="{{Config::get('app.staticurl')}}/css/compiled/v2/style.css" rel="stylesheet" media="screen">

    @if ( $is_mod )
	<link href="{{Config::get('app.staticurl')}}/css/compiled/v2/admin/admin-moderator.css" rel="stylesheet" media="screen">
    @endif

    <!--Favicon-->
    <link href="/favicon.ico" rel="icon" type="image/x-icon" />
	<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    
    <!--Fonts-->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700|Fjalla+One' rel='stylesheet' type='text/css'>    
    
    <!--{{App::environment()}}-->
	<script>
		@if(App::environment('local') )
			window.site_url = '/tt/';//has trailing slash
		@elseif(App::environment('web') || App::environment('sharktopus'))
			window.site_url = '/';//has trailing slash
		@else
			window.site_url = '/';//has trailing slash
		@endif
			window.image_url = '{{ Config::get('app.imageurl') }}';
	</script>
	
	@if($have_user)
	<script>
		window.cur_notifications = {{ json_encode($notifications_ids) }};
	</script>
	@endif
	
	{{--Generic Social stuff--}}
	<meta property="og:site_name" content="Two Thousand Times" />
	<meta property="og:url" content="{{Request::url()}}" />

	
	<meta itemprop="url" content="{{Request::url()}}" />

	<!--Page Specific CSS-->
	@yield('css')
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="{{Config::get('app.staticurl')}}/js/html5shiv.js"></script>
      <script src="{{Config::get('app.staticurl')}}/js/respond.min.js"></script>
    <![endif]-->
  </head>
<body>
@include('v2.layouts.header')

@if ( $is_mod )
	@include('v2.layouts.admin-moderator')
@endif
	
<div class="content-wrapper">
@yield('filters')

@yield('content','Fudge no content defined.')

@include('v2.layouts.footer')
 </div>
	<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/libs/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/libs/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/libs/jquery.scrolltofixed.min.js"></script>
	<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/global.js"></script>
	<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/vendor/handlebars/handlebars.min.js"></script>
	<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/vendor/sidr/jquery.sidr.min.js"></script>
	<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/v2/header.js"></script>
	<!-- @if ( $is_mobile )
		<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/vendor/touch-swipe/jquery.touchSwipe.min.js"></script>
		<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/v2/header-swipe.js"></script>
	@endif -->
	
	
	@if( $have_user )
		<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/global-loggedin.js"></script>
	@else
		<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/global-nologin.js"></script>
	@endif

	@if( $is_mod )
		<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/v2/admin/moderator.js"></script>
	@endif

	@if( $is_admin )
		<script type="text/javascript" src="{{Config::get('app.staticurl')}}/js/v2/admin/admin.js"></script>
	@endif
	
	<!--Extra Javascript-->
	@yield('js')
    
	@if($app->environment() == 'ec2-beta')
    	<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-53883988-3', 'auto');
		  ga('send', 'pageview');

		</script>
	@endif
</body>
</html>
<!-- {{ $app->environment() }}  {{$_SERVER['SERVER_ADDR']}}-->
