@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('rekening-bank.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Form Edit Rekening Bank
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
                <form action="{{route('rekening-bank.update', $rekening_bank->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Bank</label>
                        <div class="col-sm-6">
                            <select name="bank_id" required class="form-control @error('bank_id') is-invalid @enderror">
                                <option value="">Pilih Bank</option>
                                @foreach($bank as $b)
                                <option @if($rekening_bank->bank_id==$b->id) selected @endif value="{{$b->id}}">{{$b->nama_bank}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('bank_id'))
                                <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nomor Rekening</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Nomor Rekening" value="{{$rekening_bank->nomor_rekening}}" name="nomor_rekening" required class="form-control  @error('nomor_rekening') is-invalid @enderror">
                            @if ($errors->has('nomor_rekening'))
                                <span class="text-danger">{{ $errors->first('nomor_rekening') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Nama" name="nama" value="{{$rekening_bank->nama}}" required class="form-control @error('nama') is-invalid @enderror">
                            @if ($errors->has('nama'))
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-6">
                            <textarea plcaeholder="Keterangan" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan">{{$rekening_bank->keterangan}}</textarea>
                            @if ($errors->has('keterangan'))
                                <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Scan Dokumen Buku Tabungan/Rekening</label>
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