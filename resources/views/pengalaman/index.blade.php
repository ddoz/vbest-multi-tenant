@extends('layout/app')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							Pengalaman
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
									<a href="{{route('pengalaman.create')}}" class="btn btn-primary">
										<i class="ti ti-plus"></i> Tambah Data
									</a>
									
								</div>
								<button type="button" class="btn btn-outline-info">
									<i class="ti ti-filter"></i> Filter Data
								</button>
							</div>

							<div class="table-responsive mt-4">
								<table id="pengalamanDatatables" class="table table-striped" style="width:100%">
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
											<th>Tgl Pelaksanaan</th>
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
			ajax: "{{ route('pengalaman.index') }}",
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