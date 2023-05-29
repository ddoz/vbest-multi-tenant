@extends('layout/verifikasi')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">                
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        Identitas Vendor
                        @if($identitas->status_dokumen=='VERIFIED')
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
                @if($identitas->status_dokumen=='VERIFIED')
                <div class="verified-by">
                    <i class="ti ti-check-box"></i>
                    Diverifikasi oleh {{$identitas->verified->name}} pada {{date("d M Y", strtotime($identitas->tgl_verifikasi))}} pkl. {{date("H.i", strtotime($identitas->tgl_verifikasi))}}
                </div>
                @endif
                
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Status Dokumen</label>
                    <div class="col-sm-6">
                        <div class="panel-label">{{$identitas->status_dokumen}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Bentuk Usaha</label>
                    <div class="col-sm-6">
                        <div class="panel-label">{{$identitas->bentuk_usaha}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Usaha</label>
                    <div class="col-sm-6">
                        <div class="panel-label">{{$identitas->nama_usaha}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">No. NPWP</label>
                    <div class="col-sm-6">
                        <div class="panel-label">{{$identitas->npwp}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Status Usaha</label>
                    <div class="col-sm-8">
                        <div class="panel-label">{{$identitas->status_usaha}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Jenis Usaha</label>
                    <div class="col-sm-8">
                        <div class="panel-label">
                            <ul>
                            @foreach(json_decode($identitas->jenis_usaha) as $ju)
                            <li>{{$ju}}</li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Produk / Jasa yang Ditawarkan</label>
                    <div class="col-sm-6">
                        <div class="panel-label">
                            <ul>
                            @foreach(explode(',',$identitas->produk_usaha) as $pu)
                                <li>{{$pu}}</li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Total Modal Usaha</label>
                    <div class="col-sm-3">
                        <div class="panel-label">{{$identitas->total_modal_usaha}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Alamat Usaha</label>
                    <div class="col-sm-6">
                        <div class="panel-label">{{$identitas->alamat_usaha}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Provinsi & Kab. / Kota</label>
                    <div class="col-sm-3">
                        <div class="panel-label">{{$identitas->provinsi->provinsi}}</div>
                    </div>
                    <div class="col-sm-3 mt-2 mt-sm-0">
                        <div class="panel-label">{{$identitas->kabupaten->kabupaten}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Kecamatan & Kelurahan</label>
                    <div class="col-sm-3">
                        <div class="panel-label">{{$identitas->kecamatan->kecamatan}}</div>
                    </div>
                    <div class="col-sm-3 mt-2 mt-sm-0">
                        <div class="panel-label">{{$identitas->kelurahan->kelurahan}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Kode Pos</label>
                    <div class="col-sm-3">
                        <div class="panel-label">{{$identitas->kode_pos}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">No. Telp. & Fax.</label>
                    <div class="col-sm-3">
                        <div class="panel-label">{{$identitas->telp}}</div>
                    </div>
                    <div class="col-sm-3 mt-2 mt-sm-0">
                        <div class="panel-label">{{$identitas->fax}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Lengkap PIC</label>
                    <div class="col-sm-6">
                        <div class="panel-label">{{$identitas->nama_pic}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">No. Telp. PIC</label>
                    <div class="col-sm-3">
                        <div class="panel-label">{{$identitas->telp_pic}}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Alamat PIC</label>
                    <div class="col-sm-6">
                        <div class="panel-label">{{$identitas->alamat_pic}}</div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group">
                    <label class="col-sm-4 col-form-label d-none d-sm-block"></label>
                    <div class="col-sm-6">
                        <form onsubmit="return confirm('Ubah Status Dokumen?')" action="{{route('identitas.state',$identitas->id)}}" method="POST">
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

@section("script")
<script>

var table = $('#verifyDatatables').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			ajax: "{{ route('verifikasi.identitas', $vendor->id) }}",
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

</script>
@endsection