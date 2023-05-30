@extends('layout.master')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
							<div class="d-flex flex-row justify-content-between">
								<div>
									Data Bank
								</div>
                                <a href="{{route('master-bank.create')}}" class="btn btn-primary">
                                    <i class="ti ti-plus"></i> Tambah Data
                                </a>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="izinDatatables" style="width:100%" class="table table-striped">
									<thead>
										<tr>
                                            <th>No</th>
                                            <th>Opsi</th>
											<th>Nama Bank</th>
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
			ajax: "{{ route('master-bank.index') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
				{data: 'nama_bank', name: 'nama_bank'},
			]
		});
	})
  });
</script>
@endsection