<!doctype html>
<html class="gr__192_241_236_31" lang="en-us">
<head>
    <meta charset="utf-8">
	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

	<meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/css/font-awesome.min.css">

    <!-- Datatables -->
    <link rel="stylesheet" href="/css/jquery.dataTables.min.css">


    <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
    <link rel="stylesheet" type="text/css" media="screen" href="/css/smartadmin-production-plugins.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/css/smartadmin-production.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/css/smartadmin-skins.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/css/your_style.css">

    <!-- SmartAdmin RTL Support  -->
    <link rel="stylesheet" type="text/css" media="screen" href="/css/smartadmin-rtl.min.css">

    <link rel="stylesheet" type="text/css" media="screen" href="/css/smartadmin-rtl.min.css">

    <!-- FAVICONS -->
    <link rel="shortcut icon" href="/css/smartadmin-rtl.min.css" type="image/x-icon">
    <link rel="icon" href="/css/smartadmin-rtl.min.css" type="image/x-icon">

    <!-- GOOGLE FONT -->
    <!--link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700"-->

    <!-- Specifying a Webpage Icon for Web Clip
         Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="/css/smartadmin-rtl.min.css">
    <link rel="apple-touch-icon" sizes="76x76" href="/css/smartadmin-rtl.min.css">
    <link rel="apple-touch-icon" sizes="120x120" href="/css/smartadmin-rtl.min.css">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/splash/touch-icon-ipad-retina.png">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="/img/splash/touch-icon-ipad-retina.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="/img/splash/touch-icon-ipad-retina.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="/img/splash/touch-icon-ipad-retina.png" media="screen and (max-device-width: 320px)">

<title>
@section('title')

    | {!! (\Auth::user()) ? \Auth::user()->hospital->hospital_name : 'CMSE-HOSPITAL' !!}
@show
</title>
</head>
<body class="smart-style-0 desktop-detected menu-on-top">

  @include('layout.header')
  @include('layout.menu')
<!-- MAIN PANEL -->
<div id="main" role="main">

    <!-- RIBBON -->
    <div id="ribbon">

        <span class="ribbon-button-alignment">
            <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
                <i class="fa fa-refresh"></i>
            </span>
        </span>

        <!-- breadcrumb -->
        <ol class="breadcrumb">
            @section('breadcrumb')
            <li><a href="{!! url('/') !!}">Home</a></li>
            @show
        </ol>
        <!-- end breadcrumb -->

        <!-- You can also add more buttons to the
        ribbon for further usability

        Example below:

        <span class="ribbon-button-alignment pull-right">
        <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
        <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
        <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
        </span> -->

    </div>
    <!-- END RIBBON -->

    <!-- MAIN CONTENT -->
    <div class="container" id="content">
        @if($errors->any())
            <div class="alert alert-block alert-danger">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <h4 class="alert-heading">Error!</h4>
                @foreach($errors->all() as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            </div>
        @endif

        @if(Session::has('flash_message'))
            <div class="alert alert-block alert-success">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <h4 class="alert-heading">Success!</h4>
                {!! Session::get('flash_message') !!}
            </div>
        @endif
      @yield('content')

    </div>
</div>
  @include('layout.footer')



@yield('footer_scripts')
</body>
</html>