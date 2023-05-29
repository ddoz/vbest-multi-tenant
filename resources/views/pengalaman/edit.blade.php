@extends('layout.app')

@section('content')
                <div class="col-sm-10">
					<div class="card card-wrapper">
						<div class="card-header">
							<a href="{{route('pengalaman.index')}}" class="btn btn-outline-warning">
								<i class="ti ti-angle-left"></i> Kembali
							</a>

							Form Edit Pengalaman
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

							<form action="{{route('pengalaman.update', $pengalaman->id)}}" method="POST" enctype="multipart/form-data">
								@csrf
								@method('PUT')
								<label for="" class="col-sm-4 col-form-label text text-info"><b>Informasi Kontrak</b></label>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Nama Kontrak</label>
									<div class="col-sm-6">
										<textarea name="nama_kontrak" required cols="30" rows="3" placeholder="Nama Kontrak" class="form-control @error('nama_kontrak') is-invalid @enderror">{{$pengalaman->nama_kontrak}}</textarea>
										@if ($errors->has('nama_kontrak'))
											<span class="text-danger">{{ $errors->first('nama_kontrak') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Lingkup Pekerjaan</label>
									<div class="col-sm-6">
										<textarea name="lingkup_pekerjaan" required cols="30" rows="10" placeholder="Lingkup Pekerjaan" class="form-control @error('lingkup_pekerjaan') is-invalid @enderror">{{$pengalaman->lingkup_pekerjaan}}</textarea>
										@if ($errors->has('lingkup_pekerjaan'))
											<span class="text-danger">{{ $errors->first('lingkup_pekerjaan') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Nomor Kontrak</label>
									<div class="col-sm-6">
										<input type="text" name="nomor_kontrak" value="{{$pengalaman->nomor_kontrak}}" placeholder="Nomor Kontrak" required class="form-control @error('nomor_kontrak') is-invalid @enderror">
										@if ($errors->has('nomor_kontrak'))
											<span class="text-danger">{{ $errors->first('nomor_kontrak') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Kategori Pekerjaan</label>
									<div class="col-sm-6">
										<select name="kategori_pekerjaan_id" class="form-control @error('kategori_pekerjaan_id') is-invalid @enderror select2" required>
											<option value="">Pilih Kategori Pekerjaan</option>
											@foreach($kategoriPekerjaan as $kp)
											<option @if($pengalaman->kategori_pekerjaan_id==$kp->id) echo selected @endif value="{{$kp->id}}">{{$kp->nama_kategori}}</option>
											@endforeach
										</select>
										@if ($errors->has('kategori_pekerjaan_id'))
											<span class="text-danger">{{ $errors->first('kategori_pekerjaan_id') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label"></label>
									<div class="col-sm-3">
										<label for="">Tgl Pelaksanaan Kontrak</label>
										<input type="text" name="pelaksanaan_kontrak" value="{{$pengalaman->pelaksanaan_kontrak}}" placeholder="Pelaksanaan Kontrak" required class="form-control datepicker @error('pelaksanaan_kontrak') is-invalid @enderror">
										@if ($errors->has('pelaksanaan_kontrak'))
											<span class="text-danger">{{ $errors->first('pelaksanaan_kontrak') }}</span>
										@endif
									</div>
									<div class="col-sm-3">
										<label for="">Tgl Selesai Kontrak</label>
										<input type="text" name="selesai_kontrak" value="{{$pengalaman->selesai_kontrak}}" placeholder="Selesai Kontrak" required class="form-control datepicker @error('selesai_kontrak') is-invalid @enderror">
										@if ($errors->has('selesai_kontrak'))
											<span class="text-danger">{{ $errors->first('selesai_kontrak') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label"></label>
									<div class="col-sm-3">
										<label for="">Tanggal Serah Terima Pekerjaan</label>
										<input type="text" name="serah_terima_pekerjaan" value="{{$pengalaman->serah_terima_pekerjaan}}" required placeholder="Serah Terima Pekerjaan" class="form-control datepicker @error('serah_terima_pekerjaan') is-invalid @enderror">
										@if ($errors->has('serah_terima_pekerjaan'))
											<span class="text-danger">{{ $errors->first('serah_terima_pekerjaan') }}</span>
										@endif
									</div>
									<div class="col-sm-3">
										<label for="">Nilai Kontrak (IDR)</label>
										<input type="text" name="nilai_kontrak" value="{{$pengalaman->nilai_kontrak}}" placeholder="Nilai Kontrak" class="form-control @error('nilai_kontrak') is-invalid @enderror">
										@if ($errors->has('nilai_kontrak'))
											<span class="text-danger">{{ $errors->first('nilai_kontrak') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Presentase Pekerjaan (%)</label>
									<div class="col-sm-6">
										<input type="text" value="{{$pengalaman->presentase_pekerjaan}}" name="presentase_pekerjaan" placeholder="Presentase Pekerjaan" required class="form-control @error('presentase_pekerjaan') is-invalid @enderror">
										@if ($errors->has('presentase_pekerjaan'))
											<span class="text-danger">{{ $errors->first('presentase_pekerjaan') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Tanggal Input Progres</label>
									<div class="col-sm-6">
										<input type="text" value="{{$pengalaman->tanggal_progress}}" placeholder="Tanggal Input Progress" name="tanggal_progress" required class="form-control datepicker @error('tanggal_progress') is-invalid @enderror">
										@if ($errors->has('tanggal_progress'))
											<span class="text-danger">{{ $errors->first('tanggal_progress') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Keterangan</label>
									<div class="col-sm-6">
										<textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" placeholder="Keterangan">{{$pengalaman->keterangan}}</textarea>
										@if ($errors->has('keterangan'))
											<span class="text-danger">{{ $errors->first('keterangan') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Scan Dokumen Lampiran Kontrak</label>
									<div class="col-sm-6">
										<div class="custom-file">
											<input type="file" name="scan_dokumen" class="custom-file-input" id="userfile" accept=".jpg,.jpeg,.png,.bmp,.pdf">
											<label class="custom-file-label" for="userfile">Pilih file</label>
										</div>
										@if ($errors->has('scan_dokumen'))
											<span class="text-danger">{{ $errors->first('scan_dokumen') }}</span>
										@endif
										<div class="alert alert-warning mt-2">Maksimum Ukuran File : 10MB. <br>Jenis file yang dibolehkan : pdf, PDF, jpg, JPG, jpeg, JPEG, png, PNG</div>
									</div>
								</div>
								
								<label for="" class="col-sm-4 col-form-label text text-info"><b>Lokasi Pekerjaan</b></label>
								<div class="">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Nama Proyek / Alamat Proyek</label>
										<div class="col-sm-6">
											<textarea class="form-control @error('nama_alamat_proyek') is-invalid @enderror" name="nama_alamat_proyek" required placeholder="Nama Proyek/Alamat Proyek">{{$pengalaman->nama_alamat_proyek}}</textarea>
											@if ($errors->has('nama_alamat_proyek'))
												<span class="text-danger">{{ $errors->first('nama_alamat_proyek') }}</span>
											@endif
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"></label>
										<div class="col-sm-3">
											<label for="">Provinsi</label>
											<select name="lokasi_pekerjaan_provinsi_id" id="lokasi_pekerjaan_provinsi_id" class="form-control @error('lokasi_pekerjaan_provinsi_id') is-invalid @enderror select2" required>
												<option value="">Pilih Provinsi</option>
												@foreach($provinsi as $p) 
													<option @if($pengalaman->lokasi_pekerjaan_provinsi_id==$p->id) selected @endif value="{{$p->id}}">{{$p->provinsi}}</option>
												@endforeach
											</select>
											@if ($errors->has('lokasi_pekerjaan_provinsi_id'))
												<span class="text-danger">{{ $errors->first('lokasi_pekerjaan_provinsi_id') }}</span>
											@endif
										</div>
										<div class="col-sm-3">
											<label for="">Kabupaten/Kota</label>
											<select name="lokasi_pekerjaan_kabupaten_id" id="lokasi_pekerjaan_kabupaten_id" class="form-control @error('lokasi_pekerjaan_kabupaten_id') is-invalid @enderror select2">
												<option value="{{$kabupatenLokasi->id}}">{{$kabupatenLokasi->kabupaten}}</option>
											</select>
											@if ($errors->has('lokasi_pekerjaan_kabupaten_id'))
												<span class="text-danger">{{ $errors->first('lokasi_pekerjaan_kabupaten_id') }}</span>
											@endif
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"></label>
										<div class="col-sm-3">
											<label for="">Kecamatan</label>
											<select name="lokasi_pekerjaan_kecamatan_id" id="lokasi_pekerjaan_kecamatan_id" required class="form-control @error('lokasi_pekerjaan_kecamatan_id') is-invalid @enderror select2">
												<option value="{{$kecamatanLokasi->id}}">{{$kecamatanLokasi->kecamatan}}</option>
											</select>
											@if ($errors->has('lokasi_pekerjaan_kecamatan_id'))
												<span class="text-danger">{{ $errors->first('lokasi_pekerjaan_kecamatan_id') }}</span>
											@endif
										</div>
										<div class="col-sm-3">
											<label for="">Kelurahan</label>
											<select name="lokasi_pekerjaan_kelurahan_id" id="lokasi_pekerjaan_kelurahan_id" required class="form-control @error('lokasi_pekerjaan_kelurahan_id') is-invalid @enderror select2">
												<option value="{{$kelurahanLokasi->id}}">{{$kelurahanLokasi->kelurahan}}</option>
											</select>
											@if ($errors->has('lokasi_pekerjaan_kelurahan_id'))
												<span class="text-danger">{{ $errors->first('lokasi_pekerjaan_kelurahan_id') }}</span>
											@endif
										</div>
									</div>
								</div>

								<label for="" class="col-sm-4 col-form-label text text-info"><b>Instansi</b></label>
								<div class="">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Instansi Pengguna Barang/Jasa</label>
										<div class="col-sm-6">
											<textarea placeholder="Instansi Pengguna Barang/Jasa" class="form-control @error('instansi_pengguna') is-invalid @enderror" required name="instansi_pengguna">{{$pengalaman->instansi_pengguna}}</textarea>
											@if ($errors->has('instansi_pengguna'))
												<span class="text-danger">{{ $errors->first('instansi_pengguna') }}</span>
											@endif
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Alamat Instansi</label>
										<div class="col-sm-6">
											<textarea class="form-control" name="alamat_instansi" required placeholder="Alamat Instansi">{{$pengalaman->alamat_instansi}}</textarea>
											@if ($errors->has('alamat_instansi'))
												<span class="text-danger">{{ $errors->first('alamat_instansi') }}</span>
											@endif
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"></label>
										<div class="col-sm-3">
											<label for="">Provinsi</label>
											<select name="instansi_provinsi_id" id="instansi_provinsi_id" class="form-control @error('instansi_provinsi_id') is-invalid @enderror select2" required>
												<option value="">Pilih Provinsi</option>
												@foreach($provinsi as $p) 
													<option @if($pengalaman->instansi_provinsi_id==$p->id) selected @endif value="{{$p->id}}">{{$p->provinsi}}</option>
												@endforeach
											</select>
											@if ($errors->has('instansi_provinsi_id'))
												<span class="text-danger">{{ $errors->first('instansi_provinsi_id') }}</span>
											@endif
										</div>
										<div class="col-sm-3">
											<label for="">Kabupaten/Kota</label>
											<select name="instansi_kabupaten_id" id="instansi_kabupaten_id" class="form-control @error('instansi_kabupaten_id') is-invalid @enderror select2">
												<option value="{{$kabupatenInstansi->id}}">{{$kabupatenInstansi->kabupaten}}</option>
											</select>
											@if ($errors->has('instansi_kabupaten_id'))
												<span class="text-danger">{{ $errors->first('instansi_kabupaten_id') }}</span>
											@endif
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label"></label>
										<div class="col-sm-3">
											<label for="">Kecamatan</label>
											<select name="instansi_kecamatan_id" id="instansi_kecamatan_id" required class="form-control @error('instansi_kecamatan_id') is-invalid @enderror select2">
												<option value="{{$kecamatanInstansi->id}}">{{$kecamatanInstansi->kecamatan}}</option>
											</select>
											@if ($errors->has('instansi_kecamatan_id'))
												<span class="text-danger">{{ $errors->first('instansi_kecamatan_id') }}</span>
											@endif
										</div>
										<div class="col-sm-3">
											<label for="">Kelurahan</label>
											<select name="instansi_kelurahan_id" id="instansi_kelurahan_id" required class="form-control @error('instansi_kelurahan_id') is-invalid @enderror select2">
												<option value="{{$kelurahanInstansi->id}}">{{$kelurahanInstansi->kelurahan}}</option>
											</select>
											@if ($errors->has('instansi_kelurahan_id'))
												<span class="text-danger">{{ $errors->first('instansi_kelurahan_id') }}</span>
											@endif
										</div>
									</div>
									<div class="form-group row">
										<label for="" class="col-sm-4 col-form-label">Telpon Instansi</label>
										<div class="col-sm-6">
											<input type="text" value="{{$pengalaman->telpon_instansi}}" name="telpon_instansi" placeholder="Telpon Instansi" required class="form-control @error('telpon_instansi') is-invalid @enderror">
											@if ($errors->has('telpon_instansi'))
												<span class="text-danger">{{ $errors->first('telpon_instansi') }}</span>
											@endif
										</div>
									</div>
								</div>
								
								Kualifikasi Bidang Usaha (Boleh lebih dari satu)
								<div class="card card-body mt-2">
									@if ($errors->has('kualifikasiBidangUsaha.*'))
										@error('kualifikasiBidangUsaha.*')
										<span class="text-danger">{{ $message }}</span>
										@enderror
									@endif
									<table id="tableBidangUsaha">
										@if(count($kualifikasiPengalaman)==0) 
											<tr>
												<td><button type="button" class="btn btn-danger btn-sm removeBidangUsaha"><i class="ti ti-trash" aria-hidden="true"></i></button></td>
												<td>
													<select class="form-control form-control-sm bidangUsahaTipe">
														<option value="">- Pilih Tipe -</option>
														@foreach($kualifikasiBidang as $kb)
														<option value="{{$kb->id}}">{{$kb->nama_kualifikasi}}</option>
														@endforeach
													</select>
												</td>
												<td>
													<select name="kualifikasiBidangUsaha[]" class="form-control form-control-sm select2">
														<option value="">- Pilih Bidang Usaha -</option>
													</select>
												</td>
											</tr>
										@endif
										@foreach($kualifikasiPengalaman as $kiu)
										<tr>
											<td><button type="button" class="btn btn-danger btn-sm removeBidangUsaha"><i class="ti ti-trash" aria-hidden="true"></i></button></td>
											<td>
												<select class="form-control form-control-sm bidangUsahaTipe">
													<option value="">- Pilih Tipe -</option>
													@foreach($kualifikasiBidang as $kb)
													<option value="{{$kb->id}}" @if($kb->id==$kiu->parent_id) selected @endif>{{$kb->nama_kualifikasi}}</option>
													@endforeach
												</select>
											</td>
											<td>
												<select name="kualifikasiBidangUsaha[]" class="form-control form-control-sm select2">
													<option value="">- Pilih Bidang Usaha -</option>
													<option value="{{$kiu->kualifikasi_bidang_id}}" selected>{{$kiu->nama_kualifikasi}}</option>
												</select>
											</td>
										</tr>
										@endforeach
									</table>
									<div class="mt-2">
										<button type="button" class="btn btn-outline-success" id="addRow">Tambah Baris Baru</button>
									</div>
								</div>
								<div class="form-group row mt-4">
									<label class="col-sm-4 col-form-label d-none d-sm-block"></label>
									<div class="col-sm-6">
										<button type="submit" class="btn btn-primary">
											<i class="ti ti-save"></i> Ubah Data
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
@endsection

@section('script')
<script>
	$("#instansi_provinsi_id").change(function() {
        var id = $(this).val();
        if(id != null) {
            $("#instansi_kabupaten_id").empty();
            $.ajax({
				url: "{{route('common.get-kabupaten')}}",
				data: {id:id},
				type: 'get',
				success: function(res, textStatus, xhr) {
					if(xhr.status==200) {
                        $("#instansi_kabupaten_id").append("<option value=''>Pilih Kabupaten</option>");
                        res.forEach(element => {							
                            $("#instansi_kabupaten_id").append("<option value='"+element.id+"'>"+element.kabupaten+"</option>");
                        });
					}
				},
				error: function(err) {
					console.log(err)
				}
			})
        }else {
            $("#instansi_kabupaten_id").empty();
            $("#instansi_kecamatan_id").empty();
            $("#instansi_kelurahan_id").empty();
            selectRefresh();
        }
    });

    $("#instansi_kabupaten_id").change(function() {
        var id = $(this).val();
        if(id != null) {
            $("#instansi_kecamatan_id").empty();
            $("#instansi_kelurahan_id").empty();
            $.ajax({
				url: "{{route('common.get-kecamatan')}}",
				data: {id:id},
				type: 'get',
				success: function(res, textStatus, xhr) {
					if(xhr.status==200) {
                        $("#instansi_kecamatan_id").append("<option value=''>Pilih Kecamatan</option>");
                        res.forEach(element => {							
                            $("#instansi_kecamatan_id").append("<option value='"+element.id+"'>"+element.kecamatan+"</option>");
                        });
					}
				},
				error: function(err) {
					console.log(err)
				}
			})
        }
    });

    $("#instansi_kecamatan_id").change(function() {
        var id = $(this).val();
        if(id != null) {
            $("#instansi_kelurahan_id").empty();
            $.ajax({
				url: "{{route('common.get-kelurahan')}}",
				data: {id:id},
				type: 'get',
				success: function(res, textStatus, xhr) {
					if(xhr.status==200) {
                        $("#instansi_kelurahan_id").append("<option value=''>Pilih Kelurahan</option>");
                        res.forEach(element => {							
                            $("#instansi_kelurahan_id").append("<option value='"+element.id+"'>"+element.kelurahan+"</option>");
                        });
					}
				},
				error: function(err) {
					console.log(err)
				}
			})
        }
    });

    $("#lokasi_pekerjaan_provinsi_id").change(function() {
        var id = $(this).val();
        if(id != null) {
            $("#lokasi_pekerjaan_kabupaten_id").empty();
            $.ajax({
				url: "{{route('common.get-kabupaten')}}",
				data: {id:id},
				type: 'get',
				success: function(res, textStatus, xhr) {
					if(xhr.status==200) {
                        $("#lokasi_pekerjaan_kabupaten_id").append("<option value=''>Pilih Kabupaten</option>");
                        res.forEach(element => {							
                            $("#lokasi_pekerjaan_kabupaten_id").append("<option value='"+element.id+"'>"+element.kabupaten+"</option>");
                        });
					}
				},
				error: function(err) {
					console.log(err)
				}
			})
        }else {
            $("#lokasi_pekerjaan_kabupaten_id").empty();
            $("#lokasi_pekerjaan_kecamatan_id").empty();
            $("#lokasi_pekerjaan_kelurahan_id").empty();
            selectRefresh();
        }
    });

    $("#lokasi_pekerjaan_kabupaten_id").change(function() {
        var id = $(this).val();
        if(id != null) {
            $("#lokasi_pekerjaan_kecamatan_id").empty();
            $("#lokasi_pekerjaan_kelurahan_id").empty();
            $.ajax({
				url: "{{route('common.get-kecamatan')}}",
				data: {id:id},
				type: 'get',
				success: function(res, textStatus, xhr) {
					if(xhr.status==200) {
                        $("#lokasi_pekerjaan_kecamatan_id").append("<option value=''>Pilih Kecamatan</option>");
                        res.forEach(element => {							
                            $("#lokasi_pekerjaan_kecamatan_id").append("<option value='"+element.id+"'>"+element.kecamatan+"</option>");
                        });
					}
				},
				error: function(err) {
					console.log(err)
				}
			})
        }
    });

    $("#lokasi_pekerjaan_kecamatan_id").change(function() {
        var id = $(this).val();
        if(id != null) {
            $("#lokasi_pekerjaan_kelurahan_id").empty();
            $.ajax({
				url: "{{route('common.get-kelurahan')}}",
				data: {id:id},
				type: 'get',
				success: function(res, textStatus, xhr) {
					if(xhr.status==200) {
                        $("#lokasi_pekerjaan_kelurahan_id").append("<option value=''>Pilih Kelurahan</option>");
                        res.forEach(element => {							
                            $("#lokasi_pekerjaan_kelurahan_id").append("<option value='"+element.id+"'>"+element.kelurahan+"</option>");
                        });
					}
				},
				error: function(err) {
					console.log(err)
				}
			})
        }
    });

	$("#addRow").click(function() {
		var tableBody = $("#tableBidangUsaha tbody");
		var markup = `<tr>
							<td><button type="button" class="btn btn-danger btn-sm removeBidangUsaha"><i class="ti ti-trash" aria-hidden="true"></i></button></td>
							<td>
								<select class="form-control form-control-sm bidangUsahaTipe">
									<option value="0">- Pilih Tipe -</option>
									@foreach($kualifikasiBidang as $kb)
									<option value="{{$kb->id}}">{{$kb->nama_kualifikasi}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select name="kualifikasiBidangUsaha[]" class="form-control form-control-sm select2">
									<option value="">- Pilih Bidang Usaha -</option>
								</select>
							</td>
						</tr>`;
        tableBody.append(markup);
		selectRefresh();
	});

	$("#tableBidangUsaha").on('click', '.removeBidangUsaha', function () {
		$(this).closest('tr').remove();
	});

	$("#tableBidangUsaha").on('change', '.bidangUsahaTipe', function() {
		var id = $(this).val();

		var $row = $(this).closest("tr"),        // Finds the closest row <tr> 
			$tds = $row.find("td:nth-child(3)"); // Finds the 2nd <td> element

		if(id!="") {
			$.ajax({
				url: "{{route('common.get-bidang-usaha')}}",
				data: {id:id},
				type: 'get',
				success: function(res, textStatus, xhr) {
					if(xhr.status==200) {
						$.each($tds, function() {
							$(this).find('select').empty();
							res.forEach(element => {							
								$(this).find('select').append("<option value='"+element.id+"'>"+element.nama_kualifikasi+"</option>");
							});
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
@endsection