@extends('layout/verifikasi')

@section('content')
				<div class="col-sm-12">
					<div class="card card-wrapper">
						<div class="card-header">
                            <div class="d-flex flex-row justify-content-between">
								<div>
                                    <a href="{{route('verifikasi.pemilik',$vendor->id)}}" class="btn btn-outline-warning btn-xs">
                                        <i class="ti ti-angle-left"></i>
                                    </a> Verifikasi Pemilik
                                    @if($pemilik->status_dokumen=='VERIFIED')
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

                            @if($pemilik->status_dokumen=="VERIFIED" && $pemilik->verified_id!=null)           
                            <div class="verified-by">
                                <i class="ti ti-check-box"></i>
                                Diverifikasi oleh {{$pemilik->verified->name}} pada {{date('d M Y',strtotime($pemilik->tgl_verifikasi))}}
                            </div>
                            @endif
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td style="width:200px">Jenis Kepemilikan</td>
                                        <td>{{$pemilik->jenis_kepemilikan->nama_jenis}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Dokumen</td>
                                        <td>{{$pemilik->status_dokumen}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td>{{$pemilik->nama}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kewarganegaraan</td>
                                        <td>{{$pemilik->nama_kewarganegaraan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Identitas</td>
                                        <td>{{$pemilik->nomor_identitas}}</td>
                                    </tr>
                                    <tr>
                                        <td>NPWP</td>
                                        <td>{{$pemilik->npwp}}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>{{$pemilik->alamat}}</td>
                                    </tr>
                                    <tr>
                                        <td>Provinsi</td>
                                        <td>{{$pemilik->provinsi->provinsi}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kabupaten</td>
                                        <td>{{$pemilik->kabupaten->kabupaten}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>{{$pemilik->kecamatan->kecamatan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kelurahan</td>
                                        <td>{{$pemilik->kelurahan->kelurahan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Saham</td>
                                        <td>{{$pemilik->jumlah_saham}}</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Saham</td>
                                        <td>{{$pemilik->jenis_saham}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Input</td>
                                        <td>{{$pemilik->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan Tambahan</td>
                                        <td>{{$pemilik->keterangan_tambahan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Update</td>
                                        <td>{{$pemilik->updated_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Lampiran Dokumen</td>
                                        <td><a href=""> <i class="ti ti-download"></i> Download Lampiran</a></td>
                                    </tr>
                                </tbody>
                            </table>
						</div>
                        <div class="card-footer">
                            <form onsubmit="return confirm('Ubah Status Dokumen?')" action="{{route('pemilik.state',$pemilik->id)}}" method="POST">
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
			ajax: "{{ route('verifikasi.formpemilik', ['vendor'=>$vendor->id,'pemilik'=>$pemilik->id]) }}",
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