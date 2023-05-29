@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                Identitas Vendor
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

                <form action="{{route('identitas.update', $identitas->id)}}" method="POST">
                    @method("PUT")
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Bentuk Usaha</label>
                        <div class="col-sm-3">
                        <select class="form-control select2 @error('bentuk_usaha') is-invalid @enderror" required name="bentuk_usaha">
                            <option @if($identitas->bentuk_usaha=='CV') selected @endif value="CV">CV</option>
                            <option @if($identitas->bentuk_usaha=='FIRMA') selected @endif value="FIRMA">FIRMA</option>
                            <option @if($identitas->bentuk_usaha=='KOEPRASI') selected @endif value="KOPERASI">KOPERASI</option>
                            <option @if($identitas->bentuk_usaha=='PD') selected @endif value="PD">PD</option>
                            <option @if($identitas->bentuk_usaha=='PT') selected @endif value="PT">PT</option>
                            <option @if($identitas->bentuk_usaha=='PERKUMPULAN') selected @endif value="PERKUMPULAN">PERKUMPULAN</option>
                            <option @if($identitas->bentuk_usaha=='PERORANGAN') selected @endif value="PERORANGAN">PERORANGAN</option>
                            <option @if($identitas->bentuk_usaha=='UNIT') selected @endif value="UNIT">UNIT</option>
                            <option @if($identitas->bentuk_usaha=='YAYASAN') selected @endif value="YAYASAN">YAYASAN</option>
                        </select>
                        @if ($errors->has('bentuk_usaha'))
                            <span class="text-danger">{{ $errors->first('bentuk_usaha') }}</span>
                        @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Usaha</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{$identitas->nama_usaha}}" required name="name" placeholder="Nama Usaha" required>
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">No. NPWP</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control @error('npwp') is-invalid @enderror" value="{{$identitas->npwp}}" required name="npwp" placeholder="NPWP" required>
                            @if ($errors->has('npwp'))
                                <span class="text-danger">{{ $errors->first('npwp') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Status Usaha</label>
                        <div class="col-sm-8">
                            <div class="form-check form-check-inline mt-2">
                                <input @if($identitas->status_usaha=='KANTOR PUSAT') echo checked='checked' @endif class="form-check-input" type="radio" value="KANTOR PUSAT" name="status_usaha" id="status1">
                                <label class="form-check-label" for="status1">KANTOR PUSAT</label>
                            </div>
                            <div class="form-check form-check-inline mt-2">
                                <input @if($identitas->status_usaha=='KANTOR CABANG') echo checked='checked' @endif class="form-check-input" type="radio" value="KANTOR CABANG" name="status_usaha" id="status2">
                                <label class="form-check-label" for="status2">KANTOR CABANG</label>
                            </div>
                            <div class="form-check form-check-inline mt-2">
                                <input @if($identitas->status_usaha=='JOINT OPERATION') echo checked='checked' @endif class="form-check-input" type="radio" value="JOINT OPERATION" name="status_usaha" id="status3"> 
                                <label class="form-check-label" for="status3">JOINT OPERATION</label>
                            </div>
                            @if ($errors->has('status_usaha'))
                                <span class="text-danger">{{ $errors->first('status_usaha') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Jenis Usaha</label>
                        @php 
                            $jeniUsaha = json_decode($identitas->jenis_usaha);
                        @endphp
                        <div class="col-sm-8">
                            <div class="custom-control custom-checkbox mb-1">
                                <input type="checkbox" value="BARANG" @if(in_array('BARANG',$jeniUsaha)) echo checked='checked' @endif name="jenis_usaha[]" class="custom-control-input" id="jenis1">
                                <label class="custom-control-label custom-line-height" for="jenis1">
                                    BARANG
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox mb-1">
                                <input type="checkbox" value="PEKERJAAN KONSTRUKSI" @if(in_array('PEKERJAAN KONSTRUKSI',$jeniUsaha)) echo checked='checked' @endif name="jenis_usaha[]" class="custom-control-input" id="jenis2">
                                <label class="custom-control-label custom-line-height" for="jenis2">
                                    PEKERJAAN KONSTRUKSI
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox mb-1">
                                <input type="checkbox" value="JASA KONSULTASI" @if(in_array('JASA KONSULTASI',$jeniUsaha)) echo checked='checked' @endif name="jenis_usaha[]" class="custom-control-input" id="jenis3">
                                <label class="custom-control-label custom-line-height" for="jenis3">
                                    JASA KONSULTASI
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox mb-1">
                                <input type="checkbox" value="JASA LAINNYA" @if(in_array('JASA LAINNYA',$jeniUsaha)) echo checked='checked' @endif name="jenis_usaha[]" class="custom-control-input" id="jenis4">
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
                            <input type="text" data-role="tagsinput" value="{{$identitas->produk_usaha}}" name="produk_usaha" class="form-control @error('produk_usaha') is-invalid @enderror" placeholder="Bisa lebih dari satu, pisahkan dengan koma">
                            @if ($errors->has('produk_usaha'))
                                <span class="text-danger">{{ $errors->first('produk_usaha') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Total Modal Usaha</label>
                        <div class="col-sm-3">
                            <select class="form-control select2 @error('total_modal_usaha') is-invalid @enderror" name="total_modal_usaha" required>
                                <option @if($identitas->total_modal_usaha=='< Rp1M (MIKRO)') echo selected @endif value="< Rp1M (MIKRO)">< Rp1M (MIKRO)</option>
                                <option @if($identitas->total_modal_usaha=='Rp1-5M (KECIL)') echo selected @endif value="Rp1-5M (KECIL)">Rp1-5M (KECIL)</option>
                                <option @if($identitas->total_modal_usaha=='Rp5-10M (MENENGAH)') echo selected @endif value="Rp5-10M (MENENGAH)">Rp5-10M (MENENGAH)</option>
                                <option @if($identitas->total_modal_usaha=='> Rp10M (BESAR)') echo selected @endif value="> Rp10M (BESAR)">> Rp10M (BESAR)</option>
                            </select>
                            @if ($errors->has('total_modal_usaha'))
                                <span class="text-danger">{{ $errors->first('total_modal_usaha') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Alamat Usaha</label>
                        <div class="col-sm-6">
                            <textarea class="form-control @error('alamat_usaha') is-invalid @enderror" required name="alamat_usaha">{{$identitas->alamat_usaha}}</textarea>
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
                                    <option @if($identitas->provinsi_id==$p->id) selected @endif value="{{$p->id}}">{{$p->provinsi}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('provinsi_id'))
                                <span class="text-danger">{{ $errors->first('provinsi_id') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3 mt-2 mt-sm-0">
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
                        <label class="col-sm-4 col-form-label">Kecamatan & Kelurahan</label>
                        <div class="col-sm-3">
                            <select name="kecamatan_id" id="kecamatan_id" required class="form-control @error('kecamatan_id') is-invalid @enderror select2">
                                <option value="">Pilih Kecamatan</option>                                
                                <option selected value="{{$kecamatan->id}}">{{$kecamatan->kecamatan}}</option>
                            </select>
                            @if ($errors->has('kecamatan_id'))
                                <span class="text-danger">{{ $errors->first('kecamatan_id') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3 mt-2 mt-sm-0">
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
                        <label class="col-sm-4 col-form-label">Kode Pos</label>
                        <div class="col-sm-3">
                            <input type="text" value="{{$identitas->kode_pos}}" class="form-control @error('kode_pos') is-invalid @enderror" placeholder="Kode Pos" name="kode_pos">
                            @if ($errors->has('kode_pos'))
                                <span class="text-danger">{{ $errors->first('kode_pos') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">No. Telp. & Fax.</label>
                        <div class="col-sm-3">
                            <input type="text" value="{{$identitas->no_telp}}" class="form-control @error('no_telp') is-invalid @enderror" placeholder="No. Telp." name="no_telp">
                            @if ($errors->has('no_telp'))
                                <span class="text-danger">{{ $errors->first('no_telp') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3 mt-2 mt-sm-0">
                            <input type="text" value="{{$identitas->fax}}" class="form-control @error('fax') is-invalid @enderror" placeholder="Fax." name="fax">
                            @if ($errors->has('fax'))
                                <span class="text-danger">{{ $errors->first('fax') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Lengkap PIC</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{$identitas->nama_pic}}" class="form-control @error('nama_pic') is-invalid @enderror" required name="nama_pic" placeholder="Nama Lengkap PIC">
                            @if ($errors->has('nama_pic'))
                                <span class="text-danger">{{ $errors->first('nama_pic') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">No. Telp. PIC</label>
                        <div class="col-sm-3">
                            <input type="text" value="{{$identitas->telp_pic}}" class="form-control @error('telp_pic') is-invalid @enderror" name="telp_pic" placeholder="No Telpon PIC">
                            @if ($errors->has('telp_pic'))
                                <span class="text-danger">{{ $errors->first('telp_pic') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Alamat Email PIC</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{$identitas->alamat_pic}}" class="form-control @error('alamat_pic') is-invalid @enderror" name="alamat_pic" placeholder="Alamat PIC">
                            @if ($errors->has('alamat_pic'))
                                <span class="text-danger">{{ $errors->first('alamat_pic') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
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