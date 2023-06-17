@extends('layout.master')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
                                    <a href="{{route('master-jenis-izin.index')}}" class="btn btn-outline-warning">
                                        <i class="ti ti-angle-left"></i> Kembali
                                    </a>
                                    Form Jenis Izin Usaha
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
                        
                        <form action="{{route('master-jenis-izin.update',$jenisizinusaha->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="jenis_izin_id" value="$jenisizinusaha->id">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nama Jenis Izin Usaha</label>
                                <div class="col-sm-6">
                                    <input type="text" value="{{$jenisizinusaha->jenis_izin}}" class="form-control @error('jenis_izin') is-invalid @enderror" value="{{old('jenis_izin')}}" placeholder="Nama Bank" name="jenis_izin">
                                    @if ($errors->has('jenis_izin'))
                                        <span class="text-danger">{{ $errors->first('jenis_izin') }}</span>
                                    @endif
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
@endsection

@section('script')
<script type="text/javascript">
 
</script>
@endsection