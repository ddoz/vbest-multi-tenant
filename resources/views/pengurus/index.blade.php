@extends('layout/app')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							Pengurus
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
							<div class="d-flex flex-row justify-content-between">
								<div>
									<a href="{{route('pengurus.create')}}" class="btn btn-primary">
										<i class="ti ti-plus"></i> Tambah Data
									</a>
									
								</div>
								<button type="button" class="btn btn-outline-info">
									<i class="ti ti-filter"></i> Filter Data
								</button>
							</div>

							<div class="table-responsive mt-4">
								<table id="pengurusDatatables" class="table table-striped" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Opsi</th>
											<th>Verified</th>
											<th>Nama</th>
											<th>Jabatan</th>
											<th>Menjabat Dari</th>
											<th>Menjabat Sampai</th>
											<th>Tgl Input</th>
											<th>Tgl Update</th>
											<th>Lampiran</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
@endsection

@section('script')
<script type="text/javascript">
  $(function () {
	$(document).ready(function() {
		var table = $('#pengurusDatatables').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			ajax: "{{ route('pengurus.index') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'status_dokumen', name: 'status_dokumen'},
				{data: 'nama', name: 'nama'},
				{data: 'jabatan', name: 'jabatan'},
				{data: 'menjabat_sejak', name: 'menjabat_sejak'},
				{data: 'menjabat_sampai', name: 'menjabat_sampai'},
				{data: 'created_at', name: 'created_at'},
				{data: 'updated_at', name: 'updated_at'},
				{data: 'lampiran', name: 'lampiran', orderable: false, searchable: false},
			],
			fixedColumns: true

		});
	})
  });

</script>
@endsection