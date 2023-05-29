@extends('layout/verifikasi')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							
							<div class="d-flex flex-row justify-content-between">
								<div>
									Data Rekening Bank
								</div>
								<label for="">
									<span class="ti ti-flag"></span> {{$vendor->identitas_vendor->bentuk_usaha}} {{$vendor->identitas_vendor->nama_usaha}}
								</label>
							</div>
						</div>
						<div class="card-body">
							
							<div class="table-responsive">
								<table id="rekeningBankDataTables" class="table table-striped">
									<thead>
										<tr>
											<th>No</th>
											<th>Opsi</th>
											<th>Verified</th>
											<th>Bank</th>
											<th>Nomor Rekening</th>
											<th>Nama</th>
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
		var table = $('#rekeningBankDataTables').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			ajax: "{{ route('verifikasi.rekening-bank', $vendor->id) }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'status_dokumen', name: 'status_dokumen'},
				{data: 'nama_bank', name: 'nama_bank'},
				{data: 'nomor_rekening', name: 'nomor_rekening'},
				{data: 'nama', name: 'nama'},
				{data: 'keterangan', name: 'keterangan'},
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

