@extends('layout/app')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							Izin Usaha
						</div>
						<div class="card-body">
							<div class="d-flex flex-row justify-content-between">
								<div>
									<a href="{{route('izin.create')}}" class="btn btn-primary">
										<i class="ti ti-plus"></i> Tambah Data
									</a>
									
								</div>
								<button type="button" class="btn btn-outline-info">
									<i class="ti ti-filter"></i> Filter Data
								</button>
							</div>

							<div class="table-responsive mt-4">
								<table id="izinDatatables" style="width:100%" class="table table-striped">
									<thead>
										<tr>
											<th>No</th>
											<th>Opsi</th>
											<th>Verified</th>
											<th>Jenis Izin</th>
											<th>Nomor Surat</th>
											<th>Berlaku Sampai</th>
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
		var table = $('#izinDatatables').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('izin.index') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'status_dokumen', name: 'status_dokumen'},
				{data: 'jenis_izin', name: 'jenis_izin'},
				{data: 'no_surat', name: 'no_surat'},
				{data: 'berlaku_sampai', name: 'berlaku_sampai'},
				{data: 'created_at', name: 'created_at'},
				{data: 'updated_at', name: 'updated_at'},
				{data: 'lampiran', name: 'lampiran', orderable: false, searchable: false},
			]
		});
	})
  });
</script>
@endsection