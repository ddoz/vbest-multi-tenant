@extends('layout.master')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
									Data Kualifikasi Bidang
								</div>
                                <a href="{{route('master-klasifikasi-bidang.create')}}" class="btn btn-primary">
                                    <i class="ti ti-plus"></i> Tambah Data
                                </a>
							</div>
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
							<div class="table-responsive">
								<table id="izinDatatables" style="width:100%" class="table table-striped">
									<thead>
										<tr>
                                            <th>No</th>
                                            <th>Opsi</th>
											<th>Jenis Kualifikasi</th>
											<th>Sub Kualifikasi Dari</th>
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
			ajax: "{{ route('master-klasifikasi-bidang.index') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'nama_kualifikasi', name: 'nama_kualifikasi'},
				{data: 'nama_kualifikasi_parent', name: 'nama_kualifikasi_parent'},
			]
		});
	})
  });
</script>
@endsection