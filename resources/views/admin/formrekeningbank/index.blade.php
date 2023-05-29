@extends('layout/verifikasi')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
                            <div class="d-flex flex-row justify-content-between">
								<div>
                                    <a href="{{route('verifikasi.rekening-bank',$vendor->id)}}" class="btn btn-outline-warning btn-xs">
                                        <i class="ti ti-angle-left"></i>
                                    </a> Verifikasi Rekening Bank
                                    @if($rekening_bank->status_dokumen=='VERIFIED')
                                        <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                                    @endif
								</div>
								<label for="">
									<span class="ti ti-flag"></span> {{$vendor->identitas_vendor->bentuk_usaha}} {{$vendor->identitas_vendor->nama_usaha}} | 
                                    <button type="button" id="btnLogVerifikasi" class="btn btn-success">
                                        <i class="ti ti-files"></i> Histori Log Data dan Verifikasi
                                    </button>
								</label>
							</div>
                        
						</div>
						<div class="card-body">
							
							@if(Session::has('success'))
								<div class="alert alert-success mt-2 alertstatus">
									{{ Session::get('success') }}
									@php
										Session::forget('success');
									@endphp
								</div>
							@endif
							@if(Session::has('fail'))
								<div class="alert alert-danger mt-2 alertstatus">
									{{ Session::get('fail') }}
									@php
										Session::forget('fail');
									@endphp
								</div>
							@endif

                            @if($rekening_bank->status_dokumen=="VERIFIED" && $rekening_bank->verified_id!=null)           
                            <div class="verified-by">
                                <i class="ti ti-check-box"></i>
                                Diverifikasi oleh {{$rekening_bank->verified->name}} pada {{date('d M Y',strtotime($rekening_bank->tgl_verifikasi))}}
                            </div>
                            @endif
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td style="width:200px">Bank</td>
                                        <td>{{$rekening_bank->bank->nama_bank}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Dokumen</td>
                                        <td>{{$rekening_bank->status_dokumen}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td>{{$rekening_bank->nama}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>{{$rekening_bank->nomor_rekening}}</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>{{$rekening_bank->keterangan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Input</td>
                                        <td>{{$rekening_bank->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Update</td>
                                        <td>{{$rekening_bank->updated_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Lampiran Dokumen</td>
                                        <td><a href=""> <i class="ti ti-download"></i> Download Lampiran</a></td>
                                    </tr>
                                </tbody>
                            </table>
						</div>
                        <div class="card-footer">
                            <form onsubmit="return confirm('Ubah Status Dokumen?')" action="{{route('rekening-bank.state',$rekening_bank->id)}}" method="POST">
                                @csrf
                                <button type="submit" name="submit" value="Y" class="btn btn-primary">
                                    <i class="ti ti-check"></i> Approve Data
                                </button>
                                <button type="submit" name="submit" value="T" class="btn btn-danger">
                                    <i class="ti ti-trash"></i> Tolak Data
                                </button>
                            </form>
                        </div>
					</div>
				</div>

    <!-- Modal -->
    <div class="modal fade" id="verifikasiLogModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiLogModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifikasiLogModalTitle">Log Verifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="verifyDatatables" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tipe</th>
                                <th>Log</th>
                                <th>Oleh</th>
                                <th>Tgl Input</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
  $(function () {
	var table = $('#verifyDatatables').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			ajax: "{{ route('verifikasi.formrekeningbank', ['vendor'=>$vendor->id,'rekening_bank'=>$rekening_bank->id]) }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},				
				{data: 'tipe', name: 'tipe'},
				{data: 'state', name: 'state'},
				{data: 'name', name: 'name'},
				{data: 'created_at', name: 'created_at'},
			],
			fixedColumns: true,
            "searchable": false,
            "lengthChange": false

		});
	$("#btnLogVerifikasi").click(function() {
        $("#verifikasiLogModal").modal();
        table.ajax.reload();
    });
  });
</script>
@endsection