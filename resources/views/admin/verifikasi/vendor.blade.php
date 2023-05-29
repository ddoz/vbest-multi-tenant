@extends('layout/verifikasi')

@section('content')
<div class="col-sm-10">
	<div class="card card-wrapper">
		<div class="card-body">
			<h4>{{$vendor->identitas_vendor->bentuk_usaha}} {{$vendor->identitas_vendor->nama_usaha}}</h4>
		</div>
	</div>
</div>
@endsection