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
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/reg.css')}}">
	
	<!-- Datepicker -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"  />
	
	<!-- TagsInput -->
	<link rel="stylesheet" href="{{asset('assets/tagsinput/tagsinput.css')}}">

	<!-- Select2 -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script src="{{asset('assets/tagsinput/tagsinput.js')}}"></script>

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
	<main class="container-fluid mt-4 mb-4">
		<div class="col-md-8 offset-md-2">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-6">
							<img src="{{asset('assets/img/vendorbest-logo-colour.png')}}" width="200px">
						</div>
						<div class="col-sm-6 text-right">
							<h5 class="reg-header">PT POLLUX SOLUSI INTEGRASI</h5>
							<div class="header-contact">
								Ruko Graha Mas Pemuda Blok AC-19<br>
								Jl. Pemuda No. 1, Kel. Jati, Kec. Pulo Gadung<br>
								Kota Jakarta Timur, DKI Jakarta<br>
								No. Telp. 0817-9662-311<br>
								Email. contact@polluxintegra.co.id
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<h1 class="text-center">FORM REGISTRASI VENDOR</h1>
					@if(Session::has('fail'))
						<div class="alert alert-danger alertstatus">
							{{ Session::get('fail') }}
							@php
								Session::forget('fail');
							@endphp
						</div>
					@endif

					<form id="formRegister" action="{{ route('register.post') }}" method="POST">
						@csrf
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Bentuk Usaha</label>
							<div class="col-sm-3">
								<select class="form-control select2 @error('bentuk_usaha') is-invalid @enderror" required name="bentuk_usaha">
									@foreach($bentukUsaha as $bu)
									<option @if(old('bentuk_usaha')==$bu->id) selected @endif value="{{$bu->id}}">CV</option>
									@endforeach
								</select>
								@if ($errors->has('bentuk_usaha'))
									<span class="text-danger">{{ $errors->first('bentuk_usaha') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Nama Usaha</label>
							<div class="col-sm-6">
								<input type="text" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" required name="name" placeholder="Nama Usaha" required>
								@if ($errors->has('name'))
									<span class="text-danger">{{ $errors->first('name') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">No. NPWP</label>
							<div class="col-sm-6">
								<input type="text" class="form-control @error('npwp') is-invalid @enderror" value="{{old('npwp')}}" required name="npwp" placeholder="NPWP" required>
								@if ($errors->has('npwp'))
									<span class="text-danger">{{ $errors->first('npwp') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Status Usaha</label>
							<div class="col-sm-8">
								<div class="form-check form-check-inline mt-2">
									<input @if(old('status_usaha')=='KANTOR PUSAT') echo checked='checked' @endif class="form-check-input" type="radio" value="KANTOR PUSAT" name="status_usaha" id="status1">
									<label class="form-check-label" for="status1">KANTOR PUSAT</label>
								</div>
								<div class="form-check form-check-inline mt-2">
									<input @if(old('status_usaha')=='KANTOR CABANG') echo checked='checked' @endif class="form-check-input" type="radio" value="KANTOR CABANG" name="status_usaha" id="status2">
									<label class="form-check-label" for="status2">KANTOR CABANG</label>
								</div>
								<div class="form-check form-check-inline mt-2">
									<input @if(old('status_usaha')=='JOINT OPERATION') echo checked='checked' @endif class="form-check-input" type="radio" value="JOINT OPERATION" name="status_usaha" id="status3"> 
									<label class="form-check-label" for="status3">JOINT OPERATION</label>
								</div>
								@if ($errors->has('status_usaha'))
									<span class="text-danger">{{ $errors->first('status_usaha') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Jenis Usaha</label>
							<div class="col-sm-8">
								<div class="custom-control custom-checkbox mb-1">
									<input type="checkbox" value="BARANG" @if(old('jenis_usaha')!=null && in_array('BARANG',old('jenis_usaha'))) echo checked='checked' @endif name="jenis_usaha[]" class="custom-control-input" id="jenis1">
									<label class="custom-control-label custom-line-height" for="jenis1">
										BARANG
									</label>
								</div>
								<div class="custom-control custom-checkbox mb-1">
									<input type="checkbox" value="PEKERJAAN KONSTRUKSI" @if(old('jenis_usaha')!=null && in_array('PEKERJAAN KONSTRUKSI',old('jenis_usaha'))) echo checked='checked' @endif name="jenis_usaha[]" class="custom-control-input" id="jenis2">
									<label class="custom-control-label custom-line-height" for="jenis2">
										PEKERJAAN KONSTRUKSI
									</label>
								</div>
								<div class="custom-control custom-checkbox mb-1">
									<input type="checkbox" value="JASA KONSULTASI" @if(old('jenis_usaha')!=null && in_array('JASA KONSULTASI',old('jenis_usaha'))) echo checked='checked' @endif name="jenis_usaha[]" class="custom-control-input" id="jenis3">
									<label class="custom-control-label custom-line-height" for="jenis3">
										JASA KONSULTASI
									</label>
								</div>
								<div class="custom-control custom-checkbox mb-1">
									<input type="checkbox" value="JASA LAINNYA" @if(old('jenis_usaha')!=null && in_array('JASA LAINNYA',old('jenis_usaha'))) echo checked='checked' @endif name="jenis_usaha[]" class="custom-control-input" id="jenis4">
									<label class="custom-control-label custom-line-height" for="jenis4">
										JASA LAINNYA
									</label>
								</div>
								@if ($errors->has('jenis_usaha'))
									<span class="text-danger">{{ $errors->first('jenis_usaha') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Produk / Jasa yang Ditawarkan</label>
							<div class="col-sm-6">
								<input type="text" data-role="tagsinput" value="{{old('produk_usaha')}}" name="produk_usaha" class="form-control @error('produk_usaha') is-invalid @enderror" placeholder="Bisa lebih dari satu, pisahkan dengan koma">
								@if ($errors->has('produk_usaha'))
									<span class="text-danger">{{ $errors->first('produk_usaha') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Total Modal Usaha</label>
							<div class="col-sm-3">
								<select class="form-control select2 @error('total_modal_usaha') is-invalid @enderror" name="total_modal_usaha" required>
									<option @if(old('total_modal_usaha')=='< Rp1M (MIKRO)') echo selected @endif value="< Rp1M (MIKRO)">< Rp1M (MIKRO)</option>
									<option @if(old('total_modal_usaha')=='Rp1-5M (KECIL)') echo selected @endif value="Rp1-5M (KECIL)">Rp1-5M (KECIL)</option>
									<option @if(old('total_modal_usaha')=='Rp5-10M (MENENGAH)') echo selected @endif value="Rp5-10M (MENENGAH)">Rp5-10M (MENENGAH)</option>
									<option @if(old('total_modal_usaha')=='> Rp10M (BESAR)') echo selected @endif value="> Rp10M (BESAR)">> Rp10M (BESAR)</option>
								</select>
								@if ($errors->has('total_modal_usaha'))
									<span class="text-danger">{{ $errors->first('total_modal_usaha') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Alamat Usaha</label>
							<div class="col-sm-6">
								<textarea class="form-control @error('alamat_usaha') is-invalid @enderror" required name="alamat_usaha">{{old('alamat_usaha')}}</textarea>
								@if ($errors->has('alamat_usaha'))
									<span class="text-danger">{{ $errors->first('alamat_usaha') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Provinsi & Kab. / Kota</label>
							<div class="col-sm-3">
								<select name="provinsi_id" id="provinsi_id" class="form-control @error('alamat') is-invalid @enderror select2" required>
									<option value="">Pilih Provinsi</option>
									@foreach($provinsi as $p) 
										<option @if(old('provinsi_id')==$p->id) selected @endif value="{{$p->id}}">{{$p->provinsi}}</option>
									@endforeach
								</select>
								@if ($errors->has('provinsi_id'))
									<span class="text-danger">{{ $errors->first('provinsi_id') }}</span>
								@endif
							</div>
							<div class="col-sm-3 mt-2 mt-sm-0">
								<select name="kabupaten_id" id="kabupaten_id" class="form-control @error('kabupaten_id') is-invalid @enderror select2"></select>
								@if ($errors->has('kabupaten_id'))
									<span class="text-danger">{{ $errors->first('kabupaten_id') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kecamatan & Kelurahan</label>
							<div class="col-sm-3">
								<select name="kecamatan_id" id="kecamatan_id" required class="form-control @error('kecamatan_id') is-invalid @enderror select2"></select>
								@if ($errors->has('kecamatan_id'))
									<span class="text-danger">{{ $errors->first('kecamatan_id') }}</span>
								@endif
							</div>
							<div class="col-sm-3 mt-2 mt-sm-0">
								<select name="kelurahan_id" id="kelurahan_id" required class="form-control @error('kelurahan_id') is-invalid @enderror select2"></select>
								@if ($errors->has('kelurahan_id'))
									<span class="text-danger">{{ $errors->first('kelurahan_id') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kode Pos</label>
							<div class="col-sm-3">
								<input type="text" value="{{old('kode_pos')}}" class="form-control @error('kode_pos') is-invalid @enderror" placeholder="Kode Pos" name="kode_pos">
								@if ($errors->has('kode_pos'))
									<span class="text-danger">{{ $errors->first('kode_pos') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">No. Telp. & Fax.</label>
							<div class="col-sm-3">
								<input type="text" value="{{old('no_telp')}}" class="form-control @error('no_telp') is-invalid @enderror" placeholder="No. Telp." name="no_telp">
								@if ($errors->has('no_telp'))
									<span class="text-danger">{{ $errors->first('no_telp') }}</span>
								@endif
							</div>
							<div class="col-sm-3 mt-2 mt-sm-0">
								<input type="text" value="{{old('fax')}}" class="form-control @error('fax') is-invalid @enderror" placeholder="Fax." name="fax">
								@if ($errors->has('fax'))
									<span class="text-danger">{{ $errors->first('fax') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Nama Lengkap PIC</label>
							<div class="col-sm-6">
								<input type="text" value="{{old('nama_pic')}}" class="form-control @error('nama_pic') is-invalid @enderror" required name="nama_pic" placeholder="Nama Lengkap PIC">
								@if ($errors->has('nama_pic'))
									<span class="text-danger">{{ $errors->first('nama_pic') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">No. Telp. PIC</label>
							<div class="col-sm-3">
								<input type="text" value="{{old('telp_pic')}}" class="form-control @error('telp_pic') is-invalid @enderror" name="telp_pic" placeholder="No Telpon PIC">
								@if ($errors->has('telp_pic'))
									<span class="text-danger">{{ $errors->first('telp_pic') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Email</label>
							<div class="col-sm-6">
								<input type="text" value="{{old('email')}}" name="email" placeholder="Email Aktif (Untuk Login)" class="form-control @error('email') is-invalid @enderror" required>
								@if ($errors->has('email'))
									<span class="text-danger">{{ $errors->first('email') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Password</label>
							<div class="col-sm-6">
								<input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required name="password">
								@if ($errors->has('password'))
									<span class="text-danger">{{ $errors->first('password') }}</span>
								@endif
							</div>
						</div>
						
						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-lg mt-2">REGISTRASI SEKARANG</button>
						</div>
						
						<div class="text-center text-muted mt-3">
							Sudah memiliki akun?
							Silakan <a href="{{url('/')}}">LOGIN di sini</a>
						</div>
					</form>
				</div>
				<div class="card-footer">
					<b>VENDORBEST</b> Vendor Management System
				</div>
			</div>
		</div>
	</main>


<script>
    $("#provinsi_id").change(function() {
        var id = $(this).val();
        if(id != null) {
            $("#kabupaten_id").empty();
            $.ajax({
				url: "{{route('common.get-kabupaten')}}",
				data: {id:id},
				type: 'get',
				success: function(res, textStatus, xhr) {
					if(xhr.status==200) {
                        $("#kabupaten_id").append("<option value=''>Pilih Kabupaten</option>");
                        res.forEach(element => {							
                            $("#kabupaten_id").append("<option value='"+element.id+"'>"+element.kabupaten+"</option>");
                        });
					}
				},
				error: function(err) {
					console.log(err)
				}
			})
        }else {
            $("#kabupaten_id").empty();
            $("#kecamatan_id").empty();
            $("#kelurahan_id").empty();
            selectRefresh();
        }
    });

    $("#kabupaten_id").change(function() {
        var id = $(this).val();
        if(id != null) {
            $("#kecamatan_id").empty();
            $("#kelurahan_id").empty();
            $.ajax({
				url: "{{route('common.get-kecamatan')}}",
				data: {id:id},
				type: 'get',
				success: function(res, textStatus, xhr) {
					if(xhr.status==200) {
                        $("#kecamatan_id").append("<option value=''>Pilih Kecamatan</option>");
                        res.forEach(element => {							
                            $("#kecamatan_id").append("<option value='"+element.id+"'>"+element.kecamatan+"</option>");
                        });
					}
				},
				error: function(err) {
					console.log(err)
				}
			})
        }
    });

    $("#kecamatan_id").change(function() {
        var id = $(this).val();
        if(id != null) {
            $("#kelurahan_id").empty();
            $.ajax({
				url: "{{route('common.get-kelurahan')}}",
				data: {id:id},
				type: 'get',
				success: function(res, textStatus, xhr) {
					if(xhr.status==200) {
                        $("#kelurahan_id").append("<option value=''>Pilih Kelurahan</option>");
                        res.forEach(element => {							
                            $("#kelurahan_id").append("<option value='"+element.id+"'>"+element.kelurahan+"</option>");
                        });
					}
				},
				error: function(err) {
					console.log(err)
				}
			})
        }
    });

    function selectRefresh() {
		$('.select2').select2({
			tags: true,
			placeholder: "Pilih Bidang usaha",
			allowClear: true,
			width: '100%'
		});
	}
</script>

</body>
</html>