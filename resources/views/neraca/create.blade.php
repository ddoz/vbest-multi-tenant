@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('neraca.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Form Laporan Keuangan - Neraca
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
                <form action="{{route('neraca.store')}}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tahun</label>
                        <div class="col-sm-6">
                            <select name="tahun" required class="form-control select2 @error('tahun') is-invalid @enderror">
                                <option value="">Pilih</option>
                                @php for($y = date('Y');$y>=2018;$y--){ @endphp
                                <option @if(old('tahun')==$y) echo selected @endif value="{{$y}}">{{$y}}</option>
                                @php }@endphp
                            </select>
                            @if ($errors->has('tahun'))
                                <span class="text-danger">{{ $errors->first('tahun') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Aset (IDR)</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{old('aset')}}" placeholder="Aset" name="aset" required class="form-control @error('aset') is-invalid @enderror">
                            @if ($errors->has('aset'))
                                <span class="text-danger">{{ $errors->first('aset') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Kewajiban (IDR)</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{old('kewajiban')}}" placeholder="Kewajiban" name="kewajiban" required class="form-control @error('kewajiban') is-invalid @enderror">
                            @if ($errors->has('kewajiban'))
                                <span class="text-danger">{{ $errors->first('kewajiban') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Modal (IDR)</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{old('modal')}}" placeholder="Modal" name="modal" required class="form-control @error('modal') is-invalid @enderror">
                            @if ($errors->has('modal'))
                                <span class="text-danger">{{ $errors->first('modal') }}</span>
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