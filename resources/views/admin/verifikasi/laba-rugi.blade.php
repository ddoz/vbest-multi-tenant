@extends('layout/verifikasi')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
									Data Laporan Keuangan - Laba Rugi
								</div>
								<label for="">
									<span class="ti ti-flag"></span> {{$vendor->identitas_vendor->bentuk_usaha}} {{$vendor->identitas_vendor->nama_usaha}}
								</label>
							</div>
						</div>
						<div class="card-body">							
							<div class="table-responsive">
								<table id="labaRugiDatatables" class="table table-striped" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Opsi</th>
											<th>Verified</th>
											<th>Tahun</th>
											<th>Pendapatan</th>
											<th>Laba Kotor</th>
											<th>Laba Bersih</th>
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
		var table = $('#labaRugiDatatables').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('verifikasi.laba-rugi',$vendor->id) }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'status_dokumen', name: 'status_dokumen'},
				{data: 'tahun', name: 'tahun'},
				{data: 'pendapatan', name: 'pendapatan'},
				{data: 'laba_kotor', name: 'laba_kotor'},
				{data: 'laba_bersih', name: 'laba_bersih'},
				{data: 'created_at', name: 'created_at'},
				{data: 'updated_at', name: 'updated_at'},
			]
		});
	})
  });
</script>
@endsection