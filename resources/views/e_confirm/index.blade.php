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

    <!--Daftar Diklat-->
    <section class="faq-section">
		<div class="pattern-layer" style="background-image: url({{ asset('tilawatipusat/landing/images/background/7.jpg') }})"></div>
		<div class="auto-container">
			<!-- Sec Title -->
			<div class="sec-title centered">
				<div class="title">Data Peserta Pendaftaran Baru</div>
				<h2>Konfirmasi data peserta baru berikut ini!</h2>
				<div class="separate"></div>
			</div>
			<div class="row clearfix">
				@foreach ($diklat as $key=>$item)
                <!-- Accordion Column -->
				<div class="accordion-column col-lg-6 col-md-12 col-sm-12">
					<!-- Accordian Box -->
					<ul class="accordion-box">	
						<!--Block-->
						<li class="accordion block"> <?php date_default_timezone_set('Asia/Jakarta'); $date=$item->tgl_awal;?>
							<div class="acc-btn" style="text-transform: capitalize"><div class="icon-outer"><span class="icon icon-plus flaticon-plus-symbol"></span> <span class="icon icon-minus flaticon-substract"></span></div><span style="text-transform: capitalize"> {{ Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }} -</span> {{ strtolower($item->program->name) }}</div>
							<div class="acc-content">
								<div class="content">
									<div class="text">
										<p style="text-transform: capitalize">
                                        {{ strtolower($item->cabang->name) }} - {{ strtolower($item->cabang->kabupaten->nama) }}  <br/>
                                        Tempat pelaksanaan : {{ $item->tempat }}</p>
                                        <hr>
                                        <div class="form-group text-right">
                                            <a href="/{{ $item->slug }}" class="btn btn-sm btn-success">masuk</a>
                                        </div>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
                @endforeach
			</div>
		</div>
	</section>
    <!--End Daftar Diklat-->

	{{-- <script>
		$(document).ready(function () {  
		console.log('pindah ke : https://konfirmasi.nurulfalah.org');
	})
	</script> --}}
@endsection

@section('script')
{{-- <script>
	$(document).ready(function () {  
		console.log('pindah ke : https://konfirmasi.nurulfalah.org');
	})
	setTimeout(function(){
			window.location.href = 'https://konfirmasi.nurulfalah.org';
		 }, 100);
</script> --}}
@endsection