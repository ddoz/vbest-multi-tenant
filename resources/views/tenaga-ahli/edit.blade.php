@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('tenaga-ahli.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Form Edit Tenaga Ahli
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
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                        @php
                            Session::forget('fail');
                        @endphp
                    </div>
                @endif    
                
                <form action="{{route('tenaga-ahli.update',$tenaga_ahli->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Jenis Tenaga Ahli</label>
                        <div class="col-sm-6">
                            <select name="jenis_tenaga_ahli_id" class="form-control @error('jenis_tenaga_ahli_id') is-invalid @enderror select2">
                                <option value="">Pilih Jenis Kepengurusan</option>
                                @foreach($jenisTenagaAhli as $jta)
                                    <option @if($tenaga_ahli->jenis_tenaga_ahli_id==$jta->id) selected @endif value="{{$jta->id}}">{{$jta->nama}}</option>
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
                            <input type="text" value="{{$tenaga_ahli->nama}}" class="form-control @error('nama') is-invalid @enderror " required name="nama" placeholder="Nama">
                            @if ($errors->has('nama'))
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-6">
                            <select name="jenis_kelamin" required class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option @if($tenaga_ahli->jenis_kelamin=='Pria') echo selected @endif value="Pria">Pria</option>
                                <option @if($tenaga_ahli->jenis_kelamin=='Wanita') echo selected @endif value="Wanita">Wanita</option>
                            </select>
                            @if ($errors->has('jenis_kelamin'))
                                <span class="text-danger">{{ $errors->first('jenis_kelamin') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-3">
                            <label for="">KTP / Nomor Paspor</label>
                            <input type="text" value="{{$tenaga_ahli->nomor_identitas}}" class="form-control @error('nomor_identitas') is-invalid @enderror" required name="nomor_identitas" placeholder="Nomor Identitas KTP/Paspor">
                            @if ($errors->has('nomor_identitas'))
                                <span class="text-danger">{{ $errors->first('nomor_identitas') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <label for="">NPWP</label>
                            <input type="text" value="{{$tenaga_ahli->npwp}}" name="npwp" required placeholder="NPWP" class="form-control @error('npwp') is-invalid @enderror">
                            @if ($errors->has('npwp'))
                                <span class="text-danger">{{ $errors->first('npwp') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{$tenaga_ahli->tanggal_lahir}}" placeholder="Tanggal Lahir" name="tanggal_lahir" required class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror">
                            @if ($errors->has('tanggal_lahir'))
                                <span class="text-danger">{{ $errors->first('tanggal_lahir') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Kewarganegaraan</label>
                        <div class="col-sm-6">
                            <select name="kewarganegaraan_id" required class="form-control @error('kewarganegaraan_id') is-invalid @enderror select2">
                                <option value="">Pilih Kewarganegaraan</option>
                                @foreach($kewarganegaraan as $kw)
                                    <option @if($tenaga_ahli->kewarganegaraan_id==$kw->id) selected @endif value="{{$kw->id}}">{{$kw->nama_kewarganegaraan}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('kewarganegaraan_id'))
                                <span class="text-danger">{{ $errors->first('kewarganegaraan_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-6">
                            <input type="email" value="{{$tenaga_ahli->email}}" name="email" placeholder="Email Aktif" required class="form-control @error('email') is-invalid @enderror">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Alamat</label>
                        <div class="col-sm-6">
                            <textarea name="alamat" required cols="2" rows="3" placeholder="Alamat" class="form-control @error('alamat') is-invalid @enderror">{{$tenaga_ahli->alamat}}</textarea>
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
                                    <option @if($tenaga_ahli->provinsi_id==$p->id) selected @endif value="{{$p->id}}">{{$p->provinsi}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('provinsi_id'))
                                <span class="text-danger">{{ $errors->first('provinsi_id') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <label for="">Kabupaten/Kota</label>
                            <select name="kabupaten_id" id="kabupaten_id" class="form-control @error('kabupaten_id') is-invalid @enderror select2">
                                <option value="{{$kabupaten->id}}">{{$kabupaten->kabupaten}}</option>
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
                                <option value="{{$kecamatan->id}}">{{$kecamatan->kecamatan}}</option>
                            </select>
                            @if ($errors->has('kecamatan_id'))
                                <span class="text-danger">{{ $errors->first('kecamatan_id') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <label for="">Kelurahan</label>
                            <select name="kelurahan_id" id="kelurahan_id" required class="form-control @error('kelurahan_id') is-invalid @enderror select2">
                                <option value="{{$kelurahan->id}}">{{$kelurahan->kelurahan}}</option>
                            </select>
                            @if ($errors->has('kelurahan_id'))
                                <span class="text-danger">{{ $errors->first('kelurahan_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Pendidikan Akhir</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{$tenaga_ahli->pendidikan_akhir}}" name="pendidikan_akhir" placeholder="Pendidikan Akhir" required class="form-control @error('pendidikan_akhir') is-invalid @enderror">
                            @if ($errors->has('pendidikan_akhir'))
                                <span class="text-danger">{{ $errors->first('pendidikan_akhir') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Jabatan</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{$tenaga_ahli->jabatan}}" name="jabatan" placeholder="Jabatan" required class="form-control @error('jabatan') is-invalid @enderror">
                            @if ($errors->has('jabatan'))
                                <span class="text-danger">{{ $errors->first('jabatan') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Profesi Keahlian</label>
                        <div class="col-sm-6">
                            <textarea name="profesi_keahlian" placeholder="Profesi Keahlian" required cols="2" rows="2" class="form-control @error('profesi_keahlian') is-invalid @enderror">{{$tenaga_ahli->profesi_keahlian}}</textarea>
                            @if ($errors->has('profesi_keahlian'))
                                <span class="text-danger">{{ $errors->first('profesi_keahlian') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-3">
                            <label for="b">Lama Pengalaman Kerja (Tahun)</label>
                            <input type="number" value="{{$tenaga_ahli->lama_pengalaman}}" placeholder="Lama Pengalaman Kerja" name="lama_pengalaman" class="form-control @error('lama_pengalaman') is-invalid @enderror">
                            @if ($errors->has('lama_pengalaman'))
                                <span class="text-danger">{{ $errors->first('lama_pengalaman') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <label for="">Status Kepegawaian</label>
                            <select name="status_kepegawaian" required class="form-control @error('status_kepegawaian') is-invalid @enderror">
                                <option value="">Pilih Status Kepegawaian</option>
                                <option @if($tenaga_ahli->status_kepegawaian=='Tetap') echo selected @endif value="Tetap">Tetap</option>
                                <option @if($tenaga_ahli->status_kepegawaian=='Tidak Tetap') echo selected @endif value="Tidak Tetap">Tidak Tetap</option>
                            </select>
                            @if ($errors->has('status_kepegawaian'))
                                <span class="text-danger">{{ $errors->first('status_kepegawaian') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan Tambahan</label>
                        <div class="col-sm-6">
                            <textarea name="keterangan_tambahan" cols="2" placeholder="Keterangan Tambahan" rows="3" class="form-control @error('keterangan_tambahan') is-invalid @enderror">{{$tenaga_ahli->keterangan_tambahan}}</textarea>
                            @if ($errors->has('keterangan_tambahan'))
                                <span class="text-danger">{{ $errors->first('keterangan_tambahan') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Scan Dokumen CV</label>
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

                    <div class="card card-body mt-2">
                        @if ($errors->has('jenis_sertifikat.*'))
                            @error('jenis_sertifikat.*')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        @endif
                        <h6>Sertifikasi</h6>
                        <div class="table-responsive">
                            <table class="table table-stripped" id="tableSertifikat">
                                <tr>
                                    <td></td>
                                    <td>Jenis Sertifikat</td>
                                    <td>Lampiran</td>
                                    <td>Bidang</td>
                                    <td>Tingkatan</td>
                                    <td>Masa Berlaku (Diterbitkan)</td>
                                    <td>Masa Berlaku (Berakhir)</td>
                                    <td>Penerbit</td>
                                    <td></td>
                                </tr>
                                @foreach($sertifikasi as $srt)
                                <tr>
                                    <td><button type="button" class="btn btn-danger btn-sm removeSertifikat"><i class="ti ti-trash" aria-hidden="true"></i></button></td>
                                    <td>   
                                        <input type="hidden" name="sertifikat_id[]" value="{{$srt->id}}">                                     
                                        <select style="width:100px;" name="jenis_sertifikat[]" class="form-control">
                                            <option value="">Pilih Jenis Sertifikat</option>
                                            <option @if($srt->jenis_sertifikat=='SKA') echo selected @endif value="SKA">SKA</option>
                                            <option @if($srt->jenis_sertifikat=='SKT') echo selected @endif value="SKT">SKT</option>
                                            <option @if($srt->jenis_sertifikat=='Lainnya') echo selected @endif value="Lainnya">Lainnya</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="file" style="width:80px;" name="lampiran[]" id="">
                                    </td>
                                    <td>
                                        <input style="width:100px;" value="{{$srt->bidang}}" name="bidang[]" placeholder="Bidang" type="text" class="form-control">
                                    </td>
                                    <td>
                                        <select name="tingkatan[]" style="width:100px;" id="" class="form-control">
                                            <option @if($srt->tingkatan=='Muda') echo selected @endif value="Muda">Muda</option>
                                            <option @if($srt->tingkatan=='Madya') echo selected @endif value="Madya">Madya</option>
                                            <option @if($srt->tingkatan=='Utama') echo selected @endif value="Utama">Utama</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" value="{{$srt->diterbitkan}}" name="diterbitkan[]" placeholder="Masa Berlaku (Diterbitkan)" class="form-control datepicker">
                                    </td>
                                    <td>
                                        <input type="text" value="{{$srt->berakhir}}" name="berakhir[]" placeholder="Masa Berlaku (Berakhir)" class="form-control datepicker">
                                    </td>
                                    <td>
                                        <select name="penerbit[]" style="width:100px;" id="" class="form-control">
                                            <option @if($srt->penerbit=='LPJK') echo selected @endif value="LPJK">LPJK</option>
                                            <option @if($srt->penerbit=='BNSP') echo selected @endif value="BNSP">BNSP</option>
                                            <option @if($srt->penerbit=='Lainnya') echo selected @endif value="Lainnya">Lainnya</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div>
                            <button type="button" id="addRowSertifikat" class="btn btn-outline-success">Tambah Baris Baru</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card card-body mt-2">
                                @if ($errors->has('tahun_pengalaman.*'))
                                    @error('tahun_pengalaman.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @endif
                                <h6>Pengalaman</h6>
                                <div class="table-responsive">
                                    <table class="table table-stripped" id="tablePengalaman">
                                        <tr>
                                            <td></td>
                                            <td>Tahun</td>
                                            <td>Uraian</td>
                                        </tr>
                                        @foreach($pengalaman as $pg)
                                        <tr>
                                            <td><button type="button" class="btn btn-danger btn-sm removePengalaman"><i class="ti ti-trash" aria-hidden="true"></i></button></td>
                                            <td>
                                                <input type="text" value="{{$pg->tahun}}" placeholder="Tahun" name="tahun_pengalaman[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" value="{{$pg->uraian}}" placeholder="Uraian" name="uraian_pengalaman[]" class="form-control">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div>
                                    <button type="button" id="addRowPengalaman" class="btn btn-outline-success">Tambah Baris Baru</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card card-body mt-2">
                                @if ($errors->has('pendidikan.*'))
                                    @error('pendidikan.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @endif
                                <h6>Pendidikan</h6>
                                <div class="table-responsive">
                                    <table class="table table-stripped" id="tablePendidikan">
                                        <tr>
                                            <td></td>
                                            <td>Tahun</td>
                                            <td>Uraian</td>
                                        </tr>
                                        @foreach($pendidikan as $pd)
                                        <tr>
                                            <td><button type="button" class="btn btn-danger btn-sm removePendidikan"><i class="ti ti-trash" aria-hidden="true"></i></button></td>
                                            <td>
                                                <input type="text" value="{{$pd->tahun}}" placeholder="Tahun" name="tahun_pendidikan[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" value="{{$pd->uraian}}" placeholder="Uraian" name="uraian_pendidikan[]" class="form-control">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div>
                                    <button type="button" id="addRowPendidikan" class="btn btn-outline-success">Tambah Baris Baru</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card card-body mt-2">
                                @if ($errors->has('bahasa.*'))
                                    @error('bahasa.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @endif
                                <h6>Kemampuan Bahasa</h6>
                                <div class="table-responsive">
                                    <table class="table table-stripped" id="tableBahasa">
                                        <tr>
                                            <td></td>
                                            <td>Uraian</td>
                                        </tr>
                                        @foreach($kemampuanBahasa as $kb)
                                        <tr>
                                            <td><button type="button" class="btn btn-danger btn-sm removeBahasa"><i class="ti ti-trash" aria-hidden="true"></i></button></td>
                                            <td>
                                                <input type="text" value="{{$kb->uraian}}" placeholder="Uraian" name="bahasa[]" class="form-control">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div>
                                    <button type="button" id="addRowBahasa" class="btn btn-outline-success">Tambah Baris Baru</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card card-body mt-2">
                                <h6>Riwayat Penyakit</h6>
                                <textarea name="riwayat_penyakit" cols="30" rows="4" class="form-control">{{$tenaga_ahli->riwayat_penyakit}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <label class="col-sm-4 col-form-label d-none d-sm-block"></label>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-save"></i> Simpan Data
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
    $("#addRowPengalaman").click(function() {
		var tableBody = $("#tablePengalaman tbody");
        var markup = `<tr>
							<td><button type="button" class="btn btn-danger btn-sm removePengalaman"><i class="ti ti-trash" aria-hidden="true"></i></button></td>
                            <td>
                                <input type="text" placeholder="Tahun" name="tahun_pengalaman[]" class="form-control">
                            </td>
                            <td>
                                <input type="text" placeholder="Uraian" name="uraian_pengalaman[]" class="form-control">
                            </td>
						</tr>`;
        tableBody.append(markup);
    });

    $("#addRowPendidikan").click(function() {
		var tableBody = $("#tablePendidikan tbody");
        var markup = `<tr>
							<td><button type="button" class="btn btn-danger btn-sm removePendidikan"><i class="ti ti-trash" aria-hidden="true"></i></button></td>
                            <td>
                                <input type="text" placeholder="Tahun" name="tahun_pendidikan[]" class="form-control">
                            </td>
                            <td>
                                <input type="text" placeholder="Uraian" name="uraian_pendidikan[]" class="form-control">
                            </td>
						</tr>`;
        tableBody.append(markup);
    });

    $("#addRowBahasa").click(function() {
		var tableBody = $("#tableBahasa tbody");
        var markup = `<tr>
							<td><button type="button" class="btn btn-danger btn-sm removeBahasa"><i class="ti ti-trash" aria-hidden="true"></i></button></td>
                            <td>
                                <input type="text" placeholder="Uraian" name="bahasa[]" class="form-control">
                            </td>
						</tr>`;
        tableBody.append(markup);
    });

    $("#tablePengalaman").on('click', '.removePengalaman', function () {
		$(this).closest('tr').remove();
	});

    $("#tablePendidikan").on('click', '.removePendidikan', function () {
		$(this).closest('tr').remove();
	});

    $("#tableBahasa").on('click', '.removeBahasa', function () {
		$(this).closest('tr').remove();
	});
    
    $("#addRowSertifikat").click(function() {
		var tableBody = $("#tableSertifikat tbody");
		var markup = `<tr>
							<td><button type="button" class="btn btn-danger btn-sm removeSertifikat"><i class="ti ti-trash" aria-hidden="true"></i></button></td>
							<td>
                                    <input type="hidden" name="sertifikat_id[]" value="0">  
                                    <select style="width:100px;" name="jenis_sertifikat" class="form-control">
                                        <option value="">Pilih Jenis Sertifikat</option>
                                        <option value="SKA">SKA</option>
                                        <option value="SKT">SKT</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
							</td>
							<td>
                                <input type="file" style="width:80px;" name="lampiran" id="">
							</td>
                            <td>
                                <input style="width:100px;" name="bidang" placeholder="Bidang" type="text" class="form-control">
                            </td>
                            <td>
                                <select name="tingkat" style="width:100px;" id="" class="form-control">
                                    <option value="Muda">Muda</option>
                                    <option value="Madya">Madya</option>
                                    <option value="Utama">Utama</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="diterbitkan" placeholder="Masa Berlaku (Diterbitkan)" class="form-control datepicker">
                            </td>
                            <td>
                                <input type="text" name="berakhir" class="form-control datepicker" placeholder="Masa Berlaku (Berakhir)">
                            </td>
                            <td>
                                <select name="penerbit" style="width:100px;" id="" class="form-control">
                                    <option value="LPJK">LPJK</option>
                                    <option value="BNSP">BNSP</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </td>
						</tr>`;
        tableBody.append(markup);
		datePickerRefresh();
	});

    $("#tableSertifikat").on('click', '.removeSertifikat', function () {
		$(this).closest('tr').remove();
	});

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
    function datePickerRefresh() {
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true
		});
	}
</script>
@endsection