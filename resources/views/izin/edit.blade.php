@extends('layout.app')

@section('content')
                <div class="col-sm-10">
					<div class="card card-wrapper">
						<div class="card-header">
							<a href="{{route('izin.index')}}" class="btn btn-outline-warning">
								<i class="ti ti-angle-left"></i> Kembali
							</a>
							Form Edit Izin Usaha
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
							
							<form action="{{route('izin.update', $izin->id)}}" method="POST">
								@method('PUT')
								@csrf
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Jenis Izin Usaha</label>
									<div class="col-sm-6">
										<select class="form-control @error('jenis_izin_usaha_id') is-invalid @enderror" name="jenis_izin_usaha_id">
											<option value="">Pilih</option>
											@foreach($jenisIzinUsaha as $jiu)
												<option @if($izin->jenis_izin_usaha_id==$jiu->id) selected @endif  value="{{$jiu->id}}">{{$jiu->jenis_izin}}</option>
											@endforeach
										</select>
										@if ($errors->has('jenis_izin_usaha_id'))
											<span class="text-danger">{{ $errors->first('jenis_izin_usaha_id') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">No. Surat</label>
									<div class="col-sm-6">
										<input type="text" value="{{$izin->no_surat}}" name="no_surat" class="form-control @error('no_surat') is-invalid @enderror" placeholder="Nomor Surat">
									</div>
									@if ($errors->has('no_surat'))
										<span class="text-danger">{{ $errors->first('no_surat') }}</span>
									@endif
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Berlaku Seumur Hidup?</label>
									<div class="col-sm-6">
										<select name="seumur_hidup" id="" required class="form-control">
											<option  @if($izin->seumur_hidup=='Tidak') selected @endif  value="Tidak">Tidak</option>
											<option @if($izin->seumur_hidup=='Ya') selected @endif value="Ya">Ya</option>
										</select>
										@if ($errors->has('seumur_hidup'))
											<span class="text-danger">{{ $errors->first('seumur_hidup') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Berlaku Sampai <br><small class='text text-info'>(Tidak Perlu Diisi Jika Seumur Hidup)</small></label>
									<div class="col-sm-6">
										<input type="text" class="form-control datepicker" placeholder="Berlaku sampai" value="{{$izin->berlaku_sampai}}" name="berlaku_sampai">
										@if ($errors->has('berlaku_sampai'))
											<span class="text-danger">{{ $errors->first('berlaku_sampai') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Kualifikasi</label>
									<div class="col-sm-6">
										<select name="kualifikasi" required class="form-control @error('kualifikasi') is-invalid @enderror">
											<option @if($izin->kualifikasi=='Kecil') selected @endif value="Kecil">Kecil</option>
											<option @if($izin->kualifikasi=='Non Kecil') selected @endif value="Non Kecil">Non Kecil</option>
										</select>
										@if ($errors->has('kualifikasi'))
											<span class="text-danger">{{ $errors->first('kualifikasi') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Instansi Penerbit</label>
									<div class="col-sm-6">
										<input type="text" name="instansi_penerbit" class="form-control @error('instansi_penerbit') is-invalid @enderror" placeholder="Instansi Penerbit" value="{{$izin->instansi_penerbit}}">
										@if ($errors->has('instansi_penerbit'))
											<span class="text-danger">{{ $errors->first('instansi_penerbit') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Keterangan</label>
									<div class="col-sm-6">
										<textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{$izin->keterangan}}</textarea>
										@if ($errors->has('keterangan'))
											<span class="text-danger">{{ $errors->first('keterangan') }}</span>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Scan Dokumen</label>
									<div class="col-sm-6">
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="userfile" accept=".jpg,.jpeg,.png,.bmp,.pdf">
											<label class="custom-file-label" for="userfile">Pilih file</label>
										</div>
										<div class="alert alert-warning mt-2">Maksimum Ukuran File : 10MB. <br>Jenis file yang dibolehkan : pdf, PDF, jpg, JPG, jpeg, JPEG, png, PNG</div>
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
										@if(count($kualifikasiIzinUsaha)==0) 
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
										@foreach($kualifikasiIzinUsaha as $kiu)
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
											<i class="ti ti-save"></i> Update Data
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