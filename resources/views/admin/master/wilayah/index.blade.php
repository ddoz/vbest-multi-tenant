@extends('layout.master')

@section('content')


				<div class="col-sm-12">
					<div class="card bg-secondary">
					<ul class="nav nav-pills nav-fill">
						<li class="nav-item">
							<a class="nav-link @if($tab=='') active @endif" href="{{route('master-wilayah.index')}}">Provinsi</a>
						</li>
						<li class="nav-item">
							<a class="nav-link @if($tab=='kabupaten') active @endif" href="{{route('master-wilayah.index')}}?tab=kabupaten">Kabupaten</a>
						</li>
						<li class="nav-item">
							<a class="nav-link @if($tab=='kecamatan') active @endif" href="{{route('master-wilayah.index')}}?tab=kecamatan">Kecamatan</a>
						</li>
						<li class="nav-item">
							<a class="nav-link @if($tab=='kelurahan') active @endif" href="{{route('master-wilayah.index')}}?tab=kelurahan">Kelurahan</a>
						</li>
					</ul>
					</div>
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
					@if($tab=='')
					<div class="card card-wrapper">						
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
									Data Provinsi
								</div>
                                <a href="{{route('master-wilayah.create')}}" class="btn btn-primary">
                                    <i class="ti ti-plus"></i> Tambah Data
                                </a>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="izinDatatables" style="width:100%" class="table table-striped">
									<thead>
										<tr>
                                            <th>No</th>
                                            <th>Opsi</th>
											<th>Provinsi</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
					@endif
					@if($tab=='kabupaten')
					<div class="card card-wrapper">						
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
									Data Kabupaten
								</div>
                                <a href="{{route('master-wilayah.create')}}?tab=kabupaten" class="btn btn-primary">
                                    <i class="ti ti-plus"></i> Tambah Data
                                </a>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="izinDatatables" style="width:100%" class="table table-striped">
									<thead>
										<tr>
                                            <th>No</th>
                                            <th>Opsi</th>
											<th>Kabupaten</th>
											<th>Provinsi</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
					@endif
					@if($tab=='kecamatan')
					<div class="card card-wrapper">						
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
									Data Kecamatan
								</div>
                                <a href="{{route('master-wilayah.create')}}?tab=kecamatan" class="btn btn-primary">
                                    <i class="ti ti-plus"></i> Tambah Data
                                </a>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="izinDatatables" style="width:100%" class="table table-striped">
									<thead>
										<tr>
                                            <th>No</th>
                                            <th>Opsi</th>
											<th>Kecamatan</th>
											<th>Kabupaten</th>
											<th>Provinsi</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
					@endif
					@if($tab=='kelurahan')
					<div class="card card-wrapper">						
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
									Data Kelurahan
								</div>
                                <a href="{{route('master-wilayah.create')}}?tab=kelurahan" class="btn btn-primary">
                                    <i class="ti ti-plus"></i> Tambah Data
                                </a>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="izinDatatables" style="width:100%" class="table table-striped">
									<thead>
										<tr>
                                            <th>No</th>
                                            <th>Opsi</th>
											<th>Kelurahan</th>
											<th>Kecamatan</th>
											<th>Kabupaten</th>
											<th>Provinsi</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
					@endif
				</div>
@endsection

@section('script')
<script type="text/javascript">
  $(function () {
	$(document).ready(function() {
		@if($tab=='')
		var table = $('#izinDatatables').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('master-wilayah.index') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'provinsi', name: 'provinsi'},
			]
		});
		@endif
		@if($tab=='kabupaten')
		var table = $('#izinDatatables').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('master-wilayah.index') }}?tab=kabupaten",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'kabupaten', name: 'kabupaten'},
				{data: 'provinsi', name: 'provinsi'},
			]
		});
		@endif
		@if($tab=='kecamatan')
		var table = $('#izinDatatables').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('master-wilayah.index') }}?tab=kecamatan",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'kecamatan', name: 'kecamatan'},
				{data: 'kabupaten', name: 'kabupaten'},
				{data: 'provinsi', name: 'provinsi'},
			]
		});
		@endif
		@if($tab=='kelurahan')
		var table = $('#izinDatatables').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('master-wilayah.index') }}?tab=kelurahan",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'kelurahan', name: 'kelurahan'},
				{data: 'kecamatan', name: 'kecamatan'},
				{data: 'kabupaten', name: 'kabupaten'},
				{data: 'provinsi', name: 'provinsi'},
			]
		});
		@endif
	})
  });
</script>
@endsection