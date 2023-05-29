@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('pelaporan-pajak.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Form Edit Pelaporan Pajak                
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
                <form action="{{route('pelaporan-pajak.update',$pelaporan_pajak->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Jenis Pelaporan Pajak</label>
                        <div class="col-sm-6">
                            <select name="jenis_pelaporan" id="" class="form-control @error('jenis_pelaporan') is-invalid @enderror select2" required>
                                <option value="">Pilih Jenis Pelaporan Pajak</option>
                                <option @if($pelaporan_pajak->jenis_pelaporan=='SPT Tahunan') selected @endif value="SPT Tahunan">SPT Tahunan</option>
                                <option @if($pelaporan_pajak->jenis_pelaporan=='SPT Masa PPH 21') selected @endif value="SPT Masa PPH 21">SPT Masa PPH 21</option>
                                <option @if($pelaporan_pajak->jenis_pelaporan=='SPT Masa PPH 25/29') selected @endif value="SPT Masa PPH 25/29">SPT Masa PPH 25/29</option>
                                <option @if($pelaporan_pajak->jenis_pelaporan=='SPT Masa PPH 23') selected @endif value="SPT Masa PPH 23">SPT Masa PPH 23</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Masa Tahun Pajak</label>
                        <div class="col-sm-6">
                            <select name="masa_tahun_pajak" required class="form-control select2 @error('masa_tahun_pajak') is-invalid @enderror">
                                <option value="">Pilih</option>
                                @php for($y = date('Y');$y>=2018;$y--){ @endphp
                                <option @if($pelaporan_pajak->masa_tahun_pajak==$y) echo selected @endif value="{{$y}}">{{$y}}</option>
                                @php }@endphp
                            </select>
                            @if ($errors->has('masa_tahun_pajak'))
                                <span class="text-danger">{{ $errors->first('masa_tahun_pajak') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nomor Bukti Penerimaan Surat</label>
                        <div class="col-sm-6">
                            <input type="text" name="nomor_bukti_surat" required value="{{$pelaporan_pajak->nomor_bukti_surat}}" class="form-control @error('nomor_bukti_surat') is-invalid @enderror">
                            @if ($errors->has('nomor_bukti_surat'))
                                <span class="text-danger">{{ $errors->first('nomor_bukti_surat') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal Bukti Penerimaan Surat</label>
                        <div class="col-sm-6">
                            <input type="text" name="tanggal_bukti_surat" value="{{$pelaporan_pajak->tanggal_bukti_surat}}" required placeholder="Tanggal Bukti Penerimaan Surat" class="form-control @error('tanggal_bukti_surat') is-invalid @enderror datepicker">
                            @if ($errors->has('tanggal_bukti_surat'))
                                <span class="text-danger">{{ $errors->first('tanggal_bukti_surat') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="keterangan">{{$pelaporan_pajak->keterangan}}</textarea>
                            @if ($errors->has('keterangan'))
                                <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Scan Dokumen Lampiran</label>
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