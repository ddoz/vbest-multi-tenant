@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('sertifikasi.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Form Sertifikat
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

                <form action="{{route('sertifikasi.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Jenis Sertifikat</label>
                        <div class="col-sm-6">
                            <select name="jenis_sertifikat" required value="{{old('jenis_sertifikat')}}" class="form-control @error('jenis_sertifikat') is-invalid @enderror select2">
                                <option value="">Pilih Jenis Sertifikat</option>
                                <option value="ISO">ISO</option>
                                <option value="SMK3">SMK3</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @if ($errors->has('jenis_sertifikat'))
                                <span class="text-danger">{{ $errors->first('jenis_sertifikat') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nomor</label>
                        <div class="col-sm-6">
                            <input type="text" name="nomor" value="{{old('nomor')}}" required class="form-control @error('nomor') is-invalid @enderror" placeholder="Nomor">
                            @if ($errors->has('nomor'))
                                <span class="text-danger">{{ $errors->first('nomor') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-3">
                            <label for="">Berlaku Seumur Hidup?</label>
                            <select name="seumur_hidup" required class="form-control @error('seumur_hidup') is-invalid @enderror">
                                <option @if(old('seumur_hidup')=='Tidak') selected @endif value="Tidak">Tidak</option>
                                <option @if(old('seumur_hidup')=='Ya') selected @endif value="Ya">Ya</option>
                            </select>
                            @if ($errors->has('seumur_hidup'))
                                <span class="text-danger">{{ $errors->first('seumur_hidup') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <label for="">Berlaku Sampai</label>
                            <input type="text" name="berlaku_sampai" value="{{old('berlaku_sampai')}}" class="form-control datepicker @error('berlaku_sampai') is-invalid @enderror">
                            @if ($errors->has('berlaku_sampai'))
                                <span class="text-danger">{{ $errors->first('berlaku_sampai') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Instansi Pemberi</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{old('instansi_pemberi')}}" placeholder="Instansi Pemberi" name="instansi_pemberi" required class="form-control @error('instansi_pemberi') is-invalid @enderror">
                            @if ($errors->has('instansi_pemberi'))
                                <span class="text-danger">{{ $errors->first('instansi_pemberi') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan Tambahan</label>
                        <div class="col-sm-6">
                            <textarea name="keterangan_tambahan" cols="2" rows="3" class="form-control @error('keterangan_tambahan') is-invalid @enderror">{{old('keterangan_tambahan')}}</textarea>
                            @if ($errors->has('keterangan_tambahan'))
                                <span class="text-danger">{{ $errors->first('keterangan_tambahan') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Scan Dokumen</label>
                        <div class="col-sm-6">
                            <div class="custom-file">
                                <input type="file" name="scan_dokumen" required class="custom-file-input" id="userfile" accept=".jpg,.jpeg,.png,.bmp,.pdf">
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
                                <i class="ti ti-save"></i> Simpan Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection