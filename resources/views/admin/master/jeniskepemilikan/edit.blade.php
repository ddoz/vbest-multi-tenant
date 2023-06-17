@extends('layout.master')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
                                    <a href="{{route('master-jenis-kepemilikan.index')}}" class="btn btn-outline-warning">
                                        <i class="ti ti-angle-left"></i> Kembali
                                    </a>
                                    Form Jenis Kepemilikan
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
                        
                        <form action="{{route('master-jenis-kepemilikan.update',$jeniskepemilikan->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="jenis_kepemilikan_id" value="$jeniskepemilikan->id">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nama Jenis Kepemilikan</label>
                                <div class="col-sm-6">
                                    <input type="text" value="{{$jeniskepemilikan->nama_jenis}}" class="form-control @error('nama_jenis') is-invalid @enderror" value="{{old('nama_jenis')}}" placeholder="Nama Bank" name="nama_jenis">
                                    @if ($errors->has('nama_jenis'))
                                        <span class="text-danger">{{ $errors->first('nama_jenis') }}</span>
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