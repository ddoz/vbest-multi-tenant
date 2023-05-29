@extends('layout/verifikasi')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
                            <div class="d-flex flex-row justify-content-between">
								<div>
                                    <a href="{{route('verifikasi.pengurus',$vendor->id)}}" class="btn btn-outline-warning btn-xs">
                                        <i class="ti ti-angle-left"></i>
                                    </a> Verifikasi Pengurus
                                    @if($pengurus->status_dokumen=='VERIFIED')
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

                            @if($pengurus->status_dokumen=="VERIFIED" && $pengurus->verified_id!=null)           
                            <div class="verified-by">
                                <i class="ti ti-check-box"></i>
                                Diverifikasi oleh {{$pengurus->verified->name}} pada {{date('d M Y',strtotime($pengurus->tgl_verifikasi))}}
                            </div>
                            @endif
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td style="width:200px">Jenis Kepengurusan</td>
                                        <td>{{$pengurus->jenis_kepengurusan->nama}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Dokumen</td>
                                        <td>{{$pengurus->status_dokumen}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td>{{$pengurus->nama}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Identitas</td>
                                        <td>{{$pengurus->nomor_identitas}}</td>
                                    </tr>
                                    <tr>
                                        <td>NPWP</td>
                                        <td>{{$pengurus->npwp}}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>{{$pengurus->alamat}}</td>
                                    </tr>
                                    <tr>
                                        <td>Provinsi</td>
                                        <td>{{$pengurus->provinsi->provinsi}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kabupaten</td>
                                        <td>{{$pengurus->kabupaten->kabupaten}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>{{$pengurus->kecamatan->kecamatan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kelurahan</td>
                                        <td>{{$pengurus->kelurahan->kelurahan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>{{$pengurus->jabatan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Menjabat Sejak</td>
                                        <td>{{$pengurus->menjabat_sejak}}</td>
                                    </tr>
                                    <tr>
                                        <td>Menjabat Sampai</td>
                                        <td>{{$pengurus->menjabat_sampai}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Input</td>
                                        <td>{{$pengurus->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan Tambahan</td>
                                        <td>{{$pengurus->keterangan_tambahan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Update</td>
                                        <td>{{$pengurus->updated_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Lampiran Dokumen</td>
                                        <td><a href=""> <i class="ti ti-download"></i> Download Lampiran</a></td>
                                    </tr>
                                </tbody>
                            </table>
						</div>
                        <div class="card-footer">
                            <form onsubmit="return confirm('Ubah Status Dokumen?')" action="{{route('pengurus.state',$pengurus->id)}}" method="POST">
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
			ajax: "{{ route('verifikasi.formpengurus', ['vendor'=>$vendor->id,'pengurus'=>$pengurus->id]) }}",
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