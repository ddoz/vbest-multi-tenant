@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('pemilik.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Form Edit Pemilik
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

                <form action="{{route('pemilik.update', $pemilik->id)}}" method="POST">
                    @method("PUT")
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Jenis Kepemilikan</label>
                        <div class="col-sm-6">
                            <select name="jenis_kepemilikan_id" required class="form-control @error('jenis_kepemilikan_id') is-invalid @enderror">
                                <option value="">Pilih Jenis Kepemilikan</option>
                                @foreach($jenisKepemilikan as $jk) 
                                    <option @if($pemilik->jenis_kepemilikan_id==$jk->id) selected @endif value="{{$jk->id}}">{{$jk->nama_jenis}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('jenis_kepemilikan_id'))
                                <span class="text-danger">{{ $errors->first('jenis_kepemilikan_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama</label>
                        <div class="col-sm-6">
                            <input type="text" name="nama" required value="{{$pemilik->nama}}" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama">
                            @if ($errors->has('nama'))
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Kewarganegaraan</label>
                        <div class="col-sm-6">
                            <select name="kewarganegaraan_id" id="" class="form-control @error('kewarganegaraan_id') is-invalid @enderror" required>
                                <option value="">Pilih Kewarganegaraan</option>
                                @foreach($kewarganegaraan as $k) 
                                    <option @if($pemilik->kewarganegaraan_id==$k->id) selected @endif value="{{$k->id}}">{{$k->nama_kewarganegaraan}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('nama'))
                                <span class="text-danger">{{ $errors->first('kewarganegaraan_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-3">
                            <label for="">KTP / Nomor Paspor</label>
                            <input type="text" placeholder="KTP / Nomor Paspor" value="{{$pemilik->nomor_identitas}}" name="nomor_identitas" required class="form-control @error('nomor_identitas') is-invalid @enderror">
                            @if ($errors->has('nomor_identitas'))
                                <span class="text-danger">{{ $errors->first('nomor_identitas') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <label for="">NPWP</label>
                            <input type="text" name="npwp" value="{{$pemilik->npwp}}" placeholder="NPWP" class="form-control @error('npwp') is-invalid @enderror">
                            @if ($errors->has('npwp'))
                                <span class="text-danger">{{ $errors->first('npwp') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Alamat</label>
                        <div class="col-sm-6">
                            <textarea name="alamat" required cols="2" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{$pemilik->alamat}}</textarea>
                            @if ($errors->has('alamat'))
                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-3">
                            <label for="">Provinsi</label>
                            <select name="provinsi_id" id="provinsi_id" class="form-control @error('alamat') is-invalid @enderror select2" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinsi as $p) 
                                    <option @if($pemilik->provinsi_id==$p->id) selected @endif value="{{$p->id}}">{{$p->provinsi}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('provinsi_id'))
                                <span class="text-danger">{{ $errors->first('provinsi_id') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <label for="">Kabupaten/Kota</label>
                            <select name="kabupaten_id" id="kabupaten_id" class="form-control @error('kabupaten_id') is-invalid @enderror select2">
                                <option value="">Pilih Kabupaten</option>                                
                                <option selected value="{{$kabupaten->id}}">{{$kabupaten->kabupaten}}</option>
                            </select>
                            @if ($errors->has('kabupaten_id'))
                                <span class="text-danger">{{ $errors->first('kabupaten_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-3">
                            <label for="">Kecamatan</label>
                            <select name="kecamatan_id" id="kecamatan_id" required class="form-control @error('kecamatan_id') is-invalid @enderror select2">
                                <option value="">Pilih Kecamatan</option>                                
                                <option selected value="{{$kecamatan->id}}">{{$kecamatan->kecamatan}}</option>
                            </select>
                            @if ($errors->has('kecamatan_id'))
                                <span class="text-danger">{{ $errors->first('kecamatan_id') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <label for="">Kelurahan</label>
                            <select name="kelurahan_id" id="kelurahan_id" required class="form-control @error('kelurahan_id') is-invalid @enderror select2">
                                <option value="">Pilih Kelurahan</option>                                
                                <option selected value="{{$kelurahan->id}}">{{$kelurahan->kelurahan}}</option>
                            </select>
                            @if ($errors->has('kelurahan_id'))
                                <span class="text-danger">{{ $errors->first('kelurahan_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Jumlah Saham</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type="text" name="jumlah_saham" required value="{{$pemilik->jumlah_saham}}" class="form-control  @error('jumlah_saham') is-invalid @enderror form-control-sm" autocomplete="off" onkeyup="NumberOnly(this)">
                                </div>
                                <div class="input-group-append">
                                    <select name="jenis_saham" class="form-control @error('jenis_saham') is-invalid @enderror form-control-sm">
                                        <option @if($pemilik->jenis_saham=='Persen') selected @endif value="Persen">Persen</option>
                                        <option @if($pemilik->jenis_saham=='Lembar') selected @endif value="Lembar">Lembar</option>
                                    </select>
                                </div>
                            </div>
                            @if ($errors->has('jumlah_saham'))
                                <span class="text-danger">{{ $errors->first('jumlah_saham') }}</span>
                            @endif
                            @if ($errors->has('jenis_saham'))
                                <span class="text-danger">{{ $errors->first('jenis_saham') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan Tambahan</label>
                        <div class="col-sm-6">
                            <textarea name="keterangan_tambahan" cols="2" rows="3" class="form-control @error('keterangan_tambahan') is-invalid @enderror">{{$pemilik->keterangan_tambahan}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Scan Dokumen KTP/Paspor/NPWP</label>
                        <div class="col-sm-6">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="userfile" accept=".jpg,.jpeg,.png,.bmp,.pdf">
                                <label class="custom-file-label" for="userfile">Pilih file</label>
                            </div>
                            <div class="alert alert-warning mt-2">Maksimum Ukuran File : 10MB. <br>Jenis file yang dibolehkan : pdf, PDF, jpg, JPG, jpeg, JPEG, png, PNG</div>
                        </div>
                    </div>
                    <div class="form-group row">
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
@endsection