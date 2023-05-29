@extends('layout/app')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							Akta
						</div>
						<div class="card-body">
							<div class="d-flex flex-row justify-content-between">
								<div>
									<a href="{{route('akta.create')}}" class="btn btn-primary">
										<i class="ti ti-plus"></i> Tambah Data
									</a>
									
								</div>
								<button type="button" class="btn btn-outline-info">
									<i class="ti ti-filter"></i> Filter Data
								</button>
							</div>

							<div id="filterPanel">

							</div>
							@if(Session::has('success'))
								<div class="alert alert-success mt-2 alertstatus">
									{{ Session::get('success') }}
									@php
										Session::forget('success');
									@endphp
								</div>
							@endif
							@if(Session::has('fail'))
								<div class="alert alert-danger mt-2 alertstatus">
									{{ Session::get('fail') }}
									@php
										Session::forget('fail');
									@endphp
								</div>
							@endif

							<div class="table-responsive mt-4">
								<table id="aktaDatatables" class="table table-striped" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Opsi</th>
											<th>Verified</th>
											<th>Jenis Akta</th>
											<th>Nomor</th>
											<th>Tgl Surat</th>
											<th>Notaris</th>
											<th>Keterangan</th>
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
		var table = $('#aktaDatatables').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			"pageLength": 25,
			"lengthMenu": [ 25, 50, 75, 100 ],
			ajax: "{{ route('akta.index') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'status_dokumen', name: 'status_dokumen'},
				{data: 'jenis_akta', name: 'jenis_akta'},
				{data: 'no_akta', name: 'no_akta'},
				{data: 'tanggal_terbit', name: 'tanggal_terbit'},
				{data: 'nama_notaris', name: 'nama_notaris'},
				{data: 'keterangan', name: 'keterangan'},
				{data: 'created_at', name: 'created_at'},
				{data: 'updated_at', name: 'updated_at'},
				{data: 'lampiran', name: 'lampiran', orderable: false, searchable: false},
			],
			fixedColumns: true,
			"drawCallback": function(settings) {
				// $('[data-toggle="tooltip"]').tooltip()
			}
		});
	})
  });
</script>
@endsection