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
							
							@if(Session::has('success'))
							<div class="alert alert-success alertstatus">
								{{ Session::get('success') }}
								@php
									Session::forget('success');
								@endphp
							</div>
							@endif
							@if(Session::has('fail'))
								<div class="alert alert-danger alertstatus">
									{{ Session::get('fail') }}
									@php
										Session::forget('fail');
									@endphp
								</div>
							@endif

							<form action="{{route('register.office')}}" method="POST">
                                @csrf
								<div class="form-label-group">
									<input value="{{old('email')}}" type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" autofocus required>
									<label for="email">Email</label>
									@if ($errors->has('email'))
										<span class="text-danger">{{ $errors->first('email') }}</span>
									@endif
								</div>
								<div>

								</div>
								<div class="form-label-group">
									<input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
									<label for="password">Password</label>
									@if ($errors->has('password'))
										<span class="text-danger">{{ $errors->first('password') }}</span>
									@endif
								</div>
								<div class="form-label-group">
									<input value="{{old('nama')}}" type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama" required>
									<label for="nama">Nama</label>
									@if ($errors->has('nama'))
										<span class="text-danger">{{ $errors->first('nama') }}</span>
									@endif
								</div>
								<div class="form-label-group">
									<input value="{{old('perusahaan')}}" type="text" name="perusahaan" id="perusahaan" class="form-control @error('perusahaan') is-invalid @enderror" placeholder="Perusahaan" required>
									<label for="perusahaan">Nama Perusahaan</label>
									@if ($errors->has('perusahaan'))
										<span class="text-danger">{{ $errors->first('perusahaan') }}</span>
									@endif
								</div>
								<div class="form-label-group">
									<input value="{{old('domain')}}" type="text" name="domain" id="domain" class="form-control @error('domain') is-invalid @enderror" placeholder="Perusahaan" required>
									<label for="domain">Sub Domain</label>
									@if ($errors->has('domain'))
										<span class="text-danger">{{ $errors->first('domain') }}</span>
									@endif
								</div>
								<div class="form-label-group text-center mb-2">
									<label for="domain">.vendorbest.com</label>
									<input type="text" class="form-control" >
								</div>
								<div>
								</div>
								<button id="btnSubmit" class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">
									<div id="textDaftar">Daftar</div>
									<div id="loader" style="display:none !important" class="d-flex align-items-center">
										<strong>Loading...</strong>
										<div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
									</div>
								</button>
							</form>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script>
	
	function startLoad() {
		$("#btnSubmit").attr('disabled','disabled');
		$("#textDaftar").hide();
		$("#loader").show();
	}
	function finishLoad() {
		$("#btnSubmit").removeAttr('disabled');
		$("#textDaftar").show();
		$("#loader").hide();
		$("#loader").attr('style','display:none !important');
	}
	$("#formRegis").submit(function(e) {
		e.preventDefault();
		startLoad();
		var form = new FormData($('#formRegis')[0]);
		$.ajax({
			url: "{{route('register.office')}}",
			type: "POST",
			data: $(this).serialize(),
			success: function(res) {
				console.log(res);
				$("#successState").show();
				$("#failState").hide();
				$("#successState").html(res.message);
				finishLoad();
			},
			error: function(err) {
				var res = JSON.parse(err.responseText);
				console.log(res);
				$("#failState").show();
				$("#successState").hide();
				$("#failState").html(res.msg);
				finishLoad();
			}
		})
	})
</script>
</body>
</html>