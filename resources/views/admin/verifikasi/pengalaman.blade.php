@extends('layout/verifikasi')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">							
							<div class="d-flex flex-row justify-content-between">
								<div>
									Data Pengalaman
								</div>
								<label for="">
									<span class="ti ti-flag"></span> {{$vendor->identitas_vendor->bentuk_usaha}} {{$vendor->identitas_vendor->nama_usaha}}
								</label>
							</div>
						</div>
						<div class="card-body">

							<div class="table-responsive">
								<table id="pengalamanDatatables" class="table table-striped">
									<thead>
										<tr>
											<th>No</th>
											<th>Opsi</th>
											<th>Verified</th>
											<th>Nama Kontrak</th>
											<th>Lingkup Pekerjaan</th>
											<th>Lokasi</th>
											<th>Pengguna Barang/Jasa</th>
											<th>Nilai Kontrak</th>
											<th>Tgl Pelasanaan</th>
											<th>Tgl Selesai</th>
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
		var table = $('#pengalamanDatatables').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('verifikasi.pengalaman', $vendor->id) }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'status_dokumen', name: 'status_dokumen'},
				{data: 'nama_kontrak', name: 'nama_kontrak'},
				{data: 'lingkup_pekerjaan', name: 'lingkup_pekerjaan'},
				{data: 'nama_alamat_proyek', name: 'nama_alamat_proyek'},
				{data: 'instansi_pengguna', name: 'instansi_pengguna'},
				{data: 'nilai_kontrak', name: 'nilai_kontrak'},
				{data: 'pelaksanaan_kontrak', name: 'pelaksanaan_kontrak'},
				{data: 'selesai_kontrak', name: 'selesai_kontrak'},
				{data: 'lampiran', name: 'lampiran', orderable: false, searchable: false},
			]
		});
	})
  });
</script>
@endsection