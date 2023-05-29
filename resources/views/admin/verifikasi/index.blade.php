@extends('layout/admin')

@section('content')
				<div class="col-md-12">
					<div class="card card-wrapper">
						<div class="card-header">
							Daftar Vendor 
						</div>
						<div class="card-body">
							<div class="d-flex flex-row justify-content-between">
								<div>									
									
								</div>
								<button type="button" class="btn btn-outline-info">
									<i class="ti ti-filter"></i> Filter Data
								</button>
							</div>

							<div class="table-responsive mt-4">
								<table id="vendorDatatables" style="width:100%" class="table table-striped">
									<thead>
										<tr>
											<th>No</th>
											<th>Opsi</th>
											<th>Username</th>
											<th>Nama</th>
											<th>Tgl Input</th>
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
		var table = $('#vendorDatatables').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('verifikasi') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'email', name: 'email'},
				{data: 'name', name: 'name'},
				{data: 'created_at', created_at: 'name'},
			]
		});
	})
  });
</script>
@endsection