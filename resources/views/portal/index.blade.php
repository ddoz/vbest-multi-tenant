<!DOCTYPE HTML>
<html>
<head>
	<title>Vendorbest | Vendor Management System</title>
	
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="robots" content="noindex, nofollow">
	<meta name="googlebot" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="icon" href="{{asset('assets/img/vendorbest-favicon.png')}}" type="image/png">
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap"> 
	
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/login.css')}}">
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
	
	<script>
	$().ready(function() {
		$('input').attr('autocomplete', 'off');
	});
	</script>
</head>
<body>
<div class="container-fluid">
	<div class="row no-gutter">
		<div class="d-none d-md-flex col-md-4 col-lg-6 bg-login" style="background-image:url({{asset('assets/img/bg.jpg')}})"></div>
		<div class="col-md-8 col-lg-6">
			<div class="login d-flex align-items-center py-5">
				<div class="container">
					<div class="row">
						<div class="col-md-9 col-lg-8 mx-auto">
							<img src="{{asset('assets/img/vendorbest-logo-colour.png')}}" width="80%" class="mx-auto d-block mb-5">
							
							@error('email')
							<div class="alert alert-danger alertstatus">
                                {{ $message }}
							</div>
							@enderror
                            @error('password')
                            <div class="alert alert-danger alertstatus">
                                {{ $message }}
							</div>
                            @enderror

                            @if(Session::has('success'))
							<div class="alert alert-success alertstatus">
								{{ Session::get('success') }}
								@php
									Session::forget('success');
								@endphp
							</div>
							@endif

							@if(Session::has('message'))
							<div class="alert alert-success alertstatus">
								{{ Session::get('message') }}
								@php
									Session::forget('message');
								@endphp
							</div>
							@endif
							
							<form action="{{route('register.office')}}" method="POST">
                                @csrf
								<div class="form-label-group">
									<input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" autofocus required>
									<label for="email">Email</label>
								</div>
								<div class="form-label-group">
									<input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama" required>
									<label for="nama">Nama</label>
								</div>
								<div class="form-label-group">
									<input type="text" name="perusahaan" id="perusahaan" class="form-control @error('perusahaan') is-invalid @enderror" placeholder="Perusahaan" required>
									<label for="nama">Nama Perusahaan</label>
								</div>
                                <div class="row">
                                    <div class="form-label-group col-md-8">
                                        <input type="text" name="subdomain" id="subdomain" class="form-control @error('perusahaan') is-invalid @enderror" placeholder="Perusahaan" required>
                                        <label for="subdomain">Sub Domain</label>
                                    </div>
                                    <div class="col-md-4 alert">
                                        .vendorbest.com
                                    </div>
                                </div>
								<button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">
									Daftar
								</button>
							</form>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>