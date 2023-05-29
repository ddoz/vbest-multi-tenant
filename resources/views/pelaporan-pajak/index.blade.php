@extends('layout/app')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							Pelaporan Pajak
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
									<a href="{{route('pelaporan-pajak.create')}}" class="btn btn-primary">
										<i class="ti ti-plus"></i> Tambah Data
									</a>
									
								</div>
								<button type="button" class="btn btn-outline-info">
									<i class="ti ti-filter"></i> Filter Data
								</button>
							</div>

							<div class="table-responsive mt-4">
								<table id="pajakDataTables" class="table table-striped">
									<thead>
										<tr>
											<th>No</th>
											<th>Opsi</th>
											<th>Verified</th>
											<th>Jenis Laporan Pajak</th>
											<th>Masa Pajak</th>
											<th>Tgl Terima Bukti</th>
											<th>Nomor Bukti</th>
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
		var table = $('#pajakDataTables').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			ajax: "{{ route('pelaporan-pajak.index') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'status_dokumen', name: 'status_dokumen'},
				{data: 'jenis_pelaporan', name: 'jenis_pelaporan'},
				{data: 'masa_tahun_pajak', name: 'masa_tahun_pajak'},
				{data: 'tanggal_bukti_surat', name: 'tanggal_bukti_surat'},
				{data: 'nomor_bukti_surat', name: 'nomor_bukti_surat'},
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