@extends('layout.pengaturan')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
									Pengaturan Website
								</div>
							</div>
						</div>
						<div class="card-body">
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

							<div class="alert alert-warning">
								Jika Tidak Di isi maka akan menggunakan Data Default.
							</div>

							<form action="{{route('pengaturan-site.store')}}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="form-group">
									<label for="">Nama Perusahaan</label>
									<input type="text" class="form-control" value="{{($site)?$site->nama_perusahaan:''}}" name="nama_perusahaan">
								</div>
								<div class="form-group">
									<label for="">Alamat Lengkap</label>
									<textarea name="alamat_lengkap" class="form-control" cols="30" rows="10" required>{{($site)?$site->alamat_lengkap:''}}</textarea>
								</div>
								<div class="form-group">
									<label for="">Logo</label>
									<input type="file" class="form-control" name="logo">
									@if($site)
										@if($site->logo!="")
										<img width="350" class="img-fluid img-thumbnail" src="{{Storage::disk('s3')->url($site->logo)}}" alt="">
										@endif
									@endif
								</div>
								<div class="form-group">
									<label for="">Background Login</label>
									<input type="file" class="form-control" name="background_login">
									@if($site)
										@if($site->background_login!="")
										<img width="350" class="img-fluid img-thumbnail" src="{{Storage::disk('s3')->url($site->background_login)}}" alt="">
										@endif
									@endif
								</div>
								<div class="form-group">
									<button class="btn btn-primary" type="submit">Simpan</button>
								</div>
							</form>
						</div>
					</div>
				</div>
@endsection

@section('script')
@endsection