@extends('layout.master')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
                                    <a href="{{route('master-wilayah.index')}}?tab={{$tab}}" class="btn btn-outline-warning">
                                        <i class="ti ti-angle-left"></i> Kembali
                                    </a>
                                    Form Wilayah
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
                        
                        <form action="{{route('master-wilayah.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            @if($tab=='')
                                <input type="hidden" name="tab" value="provinsi">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Provinsi</label>
                                    <div class="col-sm-6">
                                        <input type="text" value="{{$data->provinsi}}" class="form-control @error('provinsi') is-invalid @enderror" value="{{old('provinsi')}}" placeholder="Nama Provinsi" name="provinsi">
                                        @if ($errors->has('provinsi'))
                                            <span class="text-danger">{{ $errors->first('provinsi') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($tab=='kabupaten')
                                <input type="hidden" name="tab" value="kabupaten">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Kabupaten</label>
                                    <div class="col-sm-6">
                                        <input type="text" value="{{$data->kabupaten}}" class="form-control @error('kabupaten') is-invalid @enderror" value="{{old('kabupaten')}}" placeholder="Nama Kabupaten" name="kabupaten">
                                        @if ($errors->has('kabupaten'))
                                            <span class="text-danger">{{ $errors->first('kabupaten') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Provinsi</label>
                                    <div class="col-sm-6">
                                        <select name="provinsi_id" id="provinsi_id" class="form-control select2" required>
                                            <option value="0">Pilih Provinsi</option>
                                            @foreach($provinsi as $pr)
                                            <option @if($pr->id==$data->provinsi_id) selected @endif value="{{$pr->id}}">{{$pr->provinsi}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('provinsi_id'))
                                            <span class="text-danger">{{ $errors->first('provinsi_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($tab=='kecamatan')
                                <input type="hidden" name="tab" value="kecamatan">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Kecamatan</label>
                                    <div class="col-sm-6">
                                        <input type="text"  value="{{$data->kecamatan}}" class="form-control @error('kecamatan') is-invalid @enderror" value="{{old('kecamatan')}}" placeholder="Nama Kecamatan" name="kecamatan" required>
                                        @if ($errors->has('kecamatan'))
                                            <span class="text-danger">{{ $errors->first('kecamatan') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Kabupaten</label>
                                    <div class="col-sm-6">
                                        <select name="kabupaten_id" id="kabupaten_id" class="form-control select2" required>
                                            <option value="0">Pilih Kabupaten</option>
                                            @foreach($kabupaten as $kb)
                                            <option @if($kb->id==$data->kabupaten_id) selected @endif value="{{$kb->id}}">{{$kb->kabupaten}} (Provinsi: {{$kb->provinsi->provinsi}})</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('kabupaten_id'))
                                            <span class="text-danger">{{ $errors->first('kabupaten_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($tab=='kelurahan')
                                <input type="hidden" name="tab" value="kelurahan">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Kelurahan</label>
                                    <div class="col-sm-6">
                                        <input type="text" value="{{$data->kelurahan}}" class="form-control @error('kelurahan') is-invalid @enderror" value="{{old('kelurahan')}}" placeholder="Nama Kelurahan" name="kelurahan" required>
                                        @if ($errors->has('kelurahan'))
                                            <span class="text-danger">{{ $errors->first('kelurahan') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Kecamatan</label>
                                    <div class="col-sm-6">
                                        <select name="kecamatan_id" id="kecamatan_id" class="form-control select2" required>
                                            <option value="0">Pilih Kecamatan</option>
                                            @foreach($kecamatan as $kb)
                                            <option @if($kb->id==$data->kecamatan_id) selected @endif value="{{$kb->id}}">{{$kb->kecamatan}}  (Provinsi: {{$kb->kabupaten->provinsi->provinsi}}. Kabupaten: {{$kb->kabupaten->kabupaten}})</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('kecamatan_id'))
                                            <span class="text-danger">{{ $errors->first('kecamatan_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

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