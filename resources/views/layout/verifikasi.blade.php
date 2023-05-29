<!DOCTYPE HTML>
<html>
<head>
	<title>Vendorbest | Vendor Management System</title>
	
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="robots" content="noindex, nofollow">
	<meta name="googlebot" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="icon" href="{{ asset('assets/img/vendorbest-favicon.png')}}" type="image/png">
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap"> 
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
	
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin.css')}}">

	<!-- DataTables -->
	<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

	<!-- Datepicker -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"  />
	
	<!-- Select2 -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.js"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script>
	$().ready(function() {
		$('input').attr('autocomplete', 'off');
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
		});
		window.setTimeout(function() {
            $(".alertstatus").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 3000);
		$(".select2").select2();
	});
	</script>
</head>
<body>
	<main>
		<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
			<a href="{{url('/')}}" class="navbar-brand"><img src="{{ asset('assets/img/vendorbest-logo-white.png')}}" width="150px"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link {{ (request()->segment(1) == 'verifikasi') ? 'active' : '' }}" href="{{route('verifikasi')}}"><i class="ti ti-check"></i> Verifikasi Data</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="masterDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="ti ti-settings"></i> Master
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="masterDropdown">
							<a class="dropdown-item" href="{{route('profil')}}"><i class="ti ti-id-badge"></i> Profil</a>
							<a class="dropdown-item" href="{{route('profil.password')}}"><i class="ti ti-key"></i> Ubah Password</a>
							<div class="dropdown-divider"></div>
							
						</div>
					</li>
				</ul>			
				<ul class="nav navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="ti ti-user"></i> {{Auth::user()->name}}
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
							<a class="dropdown-item" href="{{route('profil')}}"><i class="ti ti-id-badge"></i> Profil</a>
							<a class="dropdown-item" href="{{route('profil.password')}}"><i class="ti ti-key"></i> Ubah Password</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('logout') }}"
									onclick="event.preventDefault();
									document.getElementById('logout-form').submit();"><i class="ti ti-power-off"></i> Logout</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>
					</li>
				</ul>
			</div>
		</nav>

		<div id="content-body" class="mt-4 mb-4">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-2">
						<div class="card bg-sidebar">
							<div class="card-body">
								<ul class="navbar-nav mr-auto">									
									@if(Auth::user()->role == 'ADMIN')
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(1) == 'verifikasi' && request()->segment(2) == 'for') ? 'active' : '' }}" href="{{route('verifikasi.for', $vendor->id)}}"><i class="ti ti-list"></i> Detail Vendor</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'identitas') ? 'active' : '' }}" href="{{route('verifikasi.identitas',$vendor->id)}}"><i class="ti ti-info-alt"></i> Verif Identitas</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'akta') ? 'active' : '' }}" href="{{route('verifikasi.akta',$vendor->id)}}"><i class="ti ti-files"></i> Verif Akta</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'izin') ? 'active' : '' }}" href="{{route('verifikasi.izin',$vendor->id)}}"><i class="ti ti-bookmark-alt"></i> Verif Izin</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'pemilik') ? 'active' : '' }}" href="{{route('verifikasi.pemilik',$vendor->id)}}"><i class="ti ti-user"></i> Verif Pemilik</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'pengurus') ? 'active' : '' }}" href="{{route('verifikasi.pengurus',$vendor->id)}}"><i class="ti ti-id-badge"></i> Verif Pengurus</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'tenaga-ahli') ? 'active' : '' }}" href="{{route('verifikasi.tenaga-ahli',$vendor->id)}}"><i class="ti ti-plug"></i> Verif Tenaga Ahli</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'sertifikasi') ? 'active' : '' }}" href="{{route('verifikasi.sertifikasi',$vendor->id)}}"><i class="ti ti-gift"></i> Verif Sertifikasi</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'pengalaman') ? 'active' : '' }}" href="{{route('verifikasi.pengalaman',$vendor->id)}}"><i class="ti ti-stats-up"></i> Verif Pengalaman</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'rekening-bank') ? 'active' : '' }}" href="{{route('verifikasi.rekening-bank',$vendor->id)}}"><i class="ti ti-wallet"></i> Verif Rekening Bank</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'laba-rugi') ? 'active' : '' }}" href="{{route('verifikasi.laba-rugi',$vendor->id)}}"><i class="ti ti-agenda"></i> Verif Laba Rugi</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'neraca') ? 'active' : '' }}" href="{{route('verifikasi.neraca',$vendor->id)}}"><i class="ti ti-agenda"></i> Verif Neraca</a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{ (request()->segment(2) == 'pelaporan-pajak') ? 'active' : '' }}" href="{{route('verifikasi.pelaporan-pajak',$vendor->id)}}"><i class="ti ti-receipt"></i> Verif Pelaporan Pajak</a>
									</li>
									
									@endif

								</ul>
							</div>
						</div>
						
					</div>
					<div class="col-md-10">
						<div class="row">
							@yield('content')
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
	</main>
	
	<script>
	$().ready(function() {
		$('#btn-toggle').click(function() {
			$('#sidebar, #content').toggleClass('hide-sidebar');
		});
	});
	</script>

	@yield('script')
</body>
</html>