@extends('layout.master')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
                                    <a href="{{route('master-klasifikasi-bidang.index')}}" class="btn btn-outline-warning">
                                        <i class="ti ti-angle-left"></i> Kembali
                                    </a>
                                    Form Kualifikasi Bidang
								</div>                               
							</div>
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
                        
                        <form action="{{route('master-klasifikasi-bidang.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nama Kualifikasi</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control @error('nama_kualifikasi') is-invalid @enderror" value="{{old('nama_kualifikasi')}}" placeholder="Nama Kualifikasi" name="nama_kualifikasi">
                                    @if ($errors->has('nama_kualifikasi'))
                                        <span class="text-danger">{{ $errors->first('nama_kualifikasi') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Sub Dari</label>
                                <div class="col-sm-6">
                                    <select name="parent_id" id="parent_id" class="form-control select2">
                                        <option value="0">Pilih Kualifikasi</option>
                                        @foreach($kualifikasibidang as $kb)
                                        <option value="{{$kb->id}}">{{$kb->nama_kualifikasi}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('parent_id'))
                                        <span class="text-danger">{{ $errors->first('parent_id') }}</span>
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
@endsection

@section('script')
<script type="text/javascript">
 
</script>
@endsection