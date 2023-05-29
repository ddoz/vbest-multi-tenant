@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('akta.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Form Akta Perusahaan
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
                <form action="{{route('akta.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        
                        <label class="col-sm-4 col-form-label">Jenis Akta</label>
                        <div class="col-sm-6">
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" id="jenis1" @if(old('jenis_akta')=='PENDIRIAN') checked='checked' @endif name="jenis_akta" value="PENDIRIAN">
                                <label class="form-check-label" for="jenis1">PENDIRIAN</label>
                            </div>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" id="jenis2" @if(old('jenis_akta')=='PERUBAHAN') checked='checked' @endif  name="jenis_akta" value="PERUBAHAN">
                                <label class="form-check-label" for="jenis2">PERUBAHAN</label>
                            </div>
                            @if ($errors->has('jenis_akta'))
                                <span class="text-danger">{{ $errors->first('jenis_akta') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">No. Akta / Tgl. Terbit</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('no_akta') is-invalid @enderror" value="{{old('no_akta')}}" placeholder="No. Akta" name="no_akta">
                            @if ($errors->has('no_akta'))
                                <span class="text-danger">{{ $errors->first('no_akta') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control datepicker @error('tanggal_terbit') is-invalid @enderror" value="{{old('tanggal_terbit')}}" placeholder="Tgl. Terbit" name="tanggal_terbit">
                            @if ($errors->has('tanggal_terbit'))
                                <span class="text-danger">{{ $errors->first('tanggal_terbit') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Notaris</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control @error('nama_notaris') is-invalid @enderror" placeholder="Nama Notaris" value="{{old('nama_notaris')}}" name="nama_notaris">
                            @if ($errors->has('nama_notaris'))
                                <span class="text-danger">{{ $errors->first('nama_notaris') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-6">
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" placeholder="Keterangan" name="keterangan" required>{{old('keterangan')}}</textarea>
                            @if ($errors->has('keterangan'))
                                <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Scan Dokumen</label>
                        <div class="col-sm-6">
                            <div class="custom-file">
                                <input required type="file" name="scan_dokumen" class="custom-file-input" id="dokumen" accept=".jpg,.jpeg,.png,.bmp,.pdf">
                                <label class="custom-file-label" for="dokumen">Pilih file</label>
                            </div>                            
                            <div class="alert alert-warning mt-2">Maksimum Ukuran File : 10MB. <br>Jenis file yang dibolehkan : pdf, PDF, jpg, JPG, jpeg, JPEG, png, PNG, bmp</div>
                            @if ($errors->has('scan_dokumen'))
                                <span class="text-danger">{{ $errors->first('scan_dokumen') }}</span>
                            @endif
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