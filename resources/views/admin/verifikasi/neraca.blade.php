@extends('layout/verifikasi')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
									Data Laporan Keuangan - Neraca
								</div>
								<label for="">
									<span class="ti ti-flag"></span> {{$vendor->identitas_vendor->bentuk_usaha}} {{$vendor->identitas_vendor->nama_usaha}}
								</label>
							</div>
						</div>
						<div class="card-body">
							
							<div class="table-responsive">
								<table id="neracaDatatables" class="table table-striped" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Opsi</th>
											<th>Verified</th>
											<th>Tahun</th>
											<th>Aset</th>
											<th>Kewajiban</th>
											<th>Modal</th>
											<th>Tgl Input</th>
											<th>Tgl Update</th>
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
		var table = $('#neracaDatatables').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('verifikasi.neraca',$vendor->id) }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'status_dokumen', name: 'status_dokumen'},
				{data: 'tahun', name: 'tahun'},
				{data: 'aset', name: 'aset'},
				{data: 'kewajiban', name: 'kewajiban'},
				{data: 'modal', name: 'modal'},
				{data: 'created_at', name: 'created_at'},
				{data: 'updated_at', name: 'updated_at'},
			]
		});
	})
  });
</script>
@endsection