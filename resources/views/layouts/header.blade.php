<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Konfirmasi Data Peserta</title>
<!-- Stylesheets -->
<link href="{{ asset('tilawatipusat/landing/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('tilawatipusat/landing/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('tilawatipusat/landing/css/responsive.css') }}" rel="stylesheet">
<meta property="og:title" content="Peserta Baru Pendaftaran Diklat"/>
<meta property="og:description" content="Konfirmasi data peserta baru"/>
<meta property="og:image" itemprop="image" content="{{ asset('assets/images/tumb.jpeg') }}">
@yield('head')

<link href="https://fonts.googleapis.com/css2?family=Niconne&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Tangerine:wght@400;700&display=swap" rel="stylesheet">

<link rel="shortcut icon" href="{{ asset('tilawatipusat/landing/images/favicon.png') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('tilawatipusat/landing/images/favicon.png') }}" type="image/x-icon">

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "b1a541c7-d7c4-4ad9-84f8-21e87df7dffd",
    });
  });
</script>
 
<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
</head>

<body class="hidden-bar-wrapper">

<div class="page-wrapper">
 	
    <!-- Preloader -->
    <div class="preloader"></div>
 	
 	<!-- Main Header / Header Style Three -->
    <header class="main-header header-style-three">
    	
		<!-- Header Upper -->
        <div class="header-upper">
        	<div class="auto-container clearfix">
            	
				<div class="pull-left logo-box">
					<div class="logo"><a href="/"><img src="{{ asset('assets/images/nf_logo.png') }}" width="150px" alt="" title=""></a></div>
				</div>
				
				<div class="pull-right">
					
					<!-- Search Box -->
					{{-- <div class="search-box">
						<form method="post" action="#">
							<div class="form-group">
								<input type="search" name="search-field" value="" placeholder="Search" required>
								<button type="submit"><span class="icon flaticon-search"></span></button>
							</div>
						</form>
					</div> --}}
					
				</div>
				
            </div>
        </div>
        <!--End Header Upper-->
		
		<!-- Header Upper -->
        <div class="header-lower">
        	<div class="auto-container clearfix">
				<div class="nav-outer clearfix">
					<!--Mobile Navigation Toggler-->
					<div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>
					<!-- Main Menu -->
					<nav class="main-menu navbar-expand-md">
						<div class="navbar-header">
							<!-- Toggle Button -->    	
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						
						<div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
							<ul class="navigation clearfix">
								<li class="current dropdown"><a href="/">Home</a>
								</li>
								<li class="dropdown"><a href="/">Menu</a>
									<ul>
										<li>
											<a href="/">Konfirmasi Data Peserta</a>
										</li>
										<li>
											<a href="{{route('seluruh.diklat')}}">Daftar Semua Diklat</a>
										</li>
										<li>
											<a href="{{route('seluruh.webinar')}}">Daftar Semua Webinar</a>
										</li>
										<li>
											<a href="{{route('broadcast')}}">Broadcast</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</nav>
					
					<!-- Main Menu End-->
					<div class="outer-box clearfix">
						<!-- Social Box -->
						<ul class="social-box">
							<li><a data-target="_blank" href="https://www.facebook.com/pes.nurulfalah" class="fa fa-facebook-f"></a></li>
							<li><a data-target="_blank" href="https://instagram.com/pesantren_nurul_falah?utm_medium=copy_link" class="fa fa-instagram"></a></li>
							<li><a data-target="_blank" href="https://youtube.com/channel/UC1Xkdp_DKN0hJL85UWxH_Gg" class="fa fa-youtube"></a></li>
						</ul>
					</div>
				</div>
				
            </div>
        </div>
        <!-- End Header Lower -->
        
		<!-- Sticky Header  -->
        <div class="sticky-header">
            <div class="auto-container clearfix">
                <!--Logo-->
                <div class="logo pull-left">
                    <a href="/" title=""><img src="{{ asset('assets/images/nf_logo.png') }}" alt="" width="120px" title=""></a>
                </div>
                <!--Right Col-->
                <div class="pull-right">
                    <!-- Main Menu -->
                    <nav class="main-menu">
                        <!--Keep This Empty / Menu will come through Javascript-->
                    </nav><!-- Main Menu End-->
					
					<!-- Main Menu End-->
					<div class="outer-box clearfix">
						
						<!-- Search Btn -->
						{{-- <div class="search-box-btn search-box-outer"><span class="icon fa fa-search"></span></div> --}}
						
						<!-- Nav Btn -->
						<div class="nav-btn navSidebar-button"><span class="icon flaticon-menu-2"></span></div>
						
					</div>
					
                </div>
            </div>
        </div><!-- End Sticky Menu -->
    
		<!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><span class="icon flaticon-multiply"></span></div>
            
            <nav class="menu-box">
                <div class="nav-logo"><a href="/"><img src="{{ asset('assets/images/nf_logo.png') }}" width="150px" alt="" title=""></a></div>
                <div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
            </nav>
        </div><!-- End Mobile Menu -->
	
    </header>
    <!-- End Main Header -->
	
	<!-- Sidebar Cart Item -->
	
	<!-- END sidebar widget item -->