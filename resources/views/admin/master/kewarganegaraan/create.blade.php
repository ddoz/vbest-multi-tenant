@extends('layout.master')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
                                    <a href="{{route('master-kewarganegaraan.index')}}" class="btn btn-outline-warning">
                                        <i class="ti ti-angle-left"></i> Kembali
                                    </a>
                                    Form Kewarganegaraan
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
                        
                        <form action="{{route('master-kewarganegaraan.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nama Kewarganegaraan</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control @error('nama_kewarganegaraan') is-invalid @enderror" value="{{old('nama_kewarganegaraan')}}" placeholder="Nama Jenis Kewarganegaraan" name="nama_kewarganegaraan">
                                    @if ($errors->has('nama_kewarganegaraan'))
                                        <span class="text-danger">{{ $errors->first('nama_kewarganegaraan') }}</span>
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