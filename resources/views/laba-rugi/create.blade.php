@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('laba-rugi.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Form Laporan Keuangan - Laba-Rugi                
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

                <form action="{{route('laba-rugi.store')}}" method="POST">
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
                        <label class="col-sm-4 col-form-label">Pendapatan (IDR)</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{old('pendapatan')}}" placeholder="Pendapatan" name="pendapatan" required class="form-control @error('pendapatan') is-invalid @enderror">
                            @if ($errors->has('pendapatan'))
                                <span class="text-danger">{{ $errors->first('pendapatan') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Laba Kotor (IDR)</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{old('laba_kotor')}}" placeholder="Laba Kotor" name="laba_kotor" required class="form-control @error('laba_kotor') is-invalid @enderror">
                            @if ($errors->has('laba_kotor'))
                                <span class="text-danger">{{ $errors->first('laba_kotor') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Laba Bersih (IDR)</label>
                        <div class="col-sm-6">
                            <input type="text" value="{{old('laba_bersih')}}" placeholder="Laba Bersih" name="laba_bersih" required class="form-control @error('laba_bersih') is-invalid @enderror">
                            @if ($errors->has('laba_bersih'))
                                <span class="text-danger">{{ $errors->first('laba_bersih') }}</span>
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