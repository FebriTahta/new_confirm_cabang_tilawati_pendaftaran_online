@extends('layouts.master')
@section('head')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <meta property="og:site_name" content="E-Certificate">
    <meta property="og:title" content="Download E-Certificate"/>
    <meta property="og:description" content="Selamat datang para pecinta Al-Qur'an, terimakasih telah ikut serta
     dalam diklat tilawati. download e-certificate anda disini"/>
     <meta property="og:image" itemprop="image" content="{{ asset('assets/images/tumb.jpeg') }}">
@endsection

@section('content')
    <!-- Page Title -->
    <section class="page-title" style="background-image: url({{asset('tilawatipusat/landing/images/banner.jpg')}})">
		<div class="pattern-layer" style="background-image: url(images/background/pattern-7.png)"></div>
    	<div class="auto-container text-primary">
			<h2>_</h2>
			<ul class="page-breadcrumb">
				<li><a href="index.html"></a></li>
				<li></li>
			</ul>
        </div>
    </section>
    <!-- End Page Title -->

    <section>
        <div class="sidebar-page-container">
            <div class="section-text">yummy</div>
            <div class="icon-layer-one" style="background-image: url(images/icons/icon-1.png)"></div>
            <div class="icon-layer-two" style="background-image: url(images/icons/icon-2.png)"></div>
            <div class="icon-layer-three" style="background-image: url(images/icons/icon-3.png)"></div>
            <div class="auto-container">
                <div class="row clearfix">
                    
                    <!-- Content Side -->
                    <div class="content-side col-lg-8 col-md-12 col-sm-12">
                        <div class="blog-classic">
                            
                            <!-- News Block Three -->
                            <div class="news-block-three">
                                <div class="inner-box">
                                    <div class="image">
                                        <img src="{{asset('assets/images/gambar1.png')}}" alt="" />
                                        <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image video-overlay-box"><span class="flaticon-play-arrow"><i class="ripple"></i></span></a>
                                    </div>
                                    <div class="lower-content">
                                        <div class="category">smoothie</div>
                                        <h3><a href="news-detail.html">Drinking Healthy And Fruity </a></h3>
                                        <ul class="post-info">
                                            <li>May 21, 2021</li>
                                            <li>2 Comments</li>
                                            <li><a href="news-detail.html">Share</a></li>
                                        </ul>
                                        <div class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudan...</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Styled Pagination -->
                            <ul class="styled-pagination text-center">
                                <li><a href="#">01</a></li>
                                <li><a href="#" class="active">02</a></li>
                                <li><a href="#">03</a></li>
                                <li class="next"><a href="#"><span class="fa fa-angle-right"></span></a></li>
                            </ul>                
                            <!-- End Styled Pagination -->
                        </div>
                    </div>
                    <!-- Sidebar Side -->
                    <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                        {{-- <aside class="sidebar sticky-top"> --}}
                        <aside class="sidebar">
                            <!-- Search -->
                            <div class="sidebar-widget search-box">
                                <div class="sidebar-title">
                                    <h6>Search Course</h6>
                                </div>
                                <form method="post" action="contact.html">
                                    <div class="form-group">
                                        <input type="search" name="search-field" value="" placeholder="Your search" required>
                                        <button type="submit"><span class="icon fa fa-search"></span></button>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- About Widget -->
                            <div class="sidebar-widget about-widget">
                                <div class="widget-content">
                                    <div class="sidebar-title">
                                        <h6>Selamat Datang Pecinta Al-Qur'an</h6>
                                    </div>
                                    <div class="text">Berikut ini adalah daftar seluruh data e-sertifikat pelatihan, anda dapat mencari data sertifikat dengan menggolongkannya berdasarkan tanggal, bulan, tahun, maupun nama pelatihannya</div>
                                </div>
                            </div>
                            
                            <!-- Category Widget -->
                            <div class="sidebar-widget category-widget">
                                <div class="widget-content">
                                    <div class="sidebar-title">
                                        <h6>Cari Berdasarkan Bulan (Tahun ini)</h6>
                                    </div>
                                    <ul class="cat-list">
                                        <li><a href="#">Januari</a></li>
                                        <li><a href="#">Februari</a></li>
                                        <li><a href="#">Maret</a></li>
                                        <li><a href="#">April</a></li>
                                        <li><a href="#">Mei</a></li>
                                        <li><a href="#">Juni</a></li>
                                        <li><a href="#">Juli</a></li>
                                        <li><a href="#">Agustus</a></li>
                                        <li><a href="#">September</a></li>
                                        <li><a href="#">Oktober</a></li>
                                        <li><a href="#">November</a></li>
                                        <li><a href="#">Desember</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Tags Posts -->
                            <div class="sidebar-widget tags-posts">
                                <div class="widget-content">
                                    <div class="sidebar-title">
                                        <h6>jenis Pelatihan</h6>
                                    </div>
                                    <ul class="cat-list">
                                        @foreach ($program as $item)
                                            <li><a href="#">{{$item->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Social Widget -->
                            <div class="sidebar-widget social-widget">
                                <div class="sidebar-title">
                                    <h6>Share</h6>
                                </div>
                                <ul class="social-list">
                                    <li><a href="#"><span class="icon fa fa-facebook"></span></a></li>
                                    <li><a href="#"><span class="icon fa fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="icon fa fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="icon fa fa-dribbble"></span></a></li>
                                </ul>
                            </div>
                            
                        </aside>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    
@endsection