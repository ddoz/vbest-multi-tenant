@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('izin.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Detail Izin Usaha
                @if($izin->verified_id!=null)    
                    <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                @endif
            </div>
            <div class="card-body">     
                @if($izin->verified_id!=null)           
                <div class="verified-by">
                    <i class="ti ti-check-box"></i>
                    Diverifikasi oleh {{$izin->verified->name}} pada {{date('d M Y',strtotime($izin->tgl_verifikasi))}}
                </div>
                @endif
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td style="width:200px">Jenis Izin</td>
                            <td>{{$izin->jenis_izin_usaha->jenis_izin}}</td>
                        </tr>
                        <tr>
                            <td>Status Dokumen</td>
                            <td>{{$izin->status_dokumen}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Surat</td>
                            <td>{{$izin->no_surat}}</td>
                        </tr>
                        <tr>
                            <td>Berlaku sampai</td>
                            <td>{{($izin->seumur_hidup=='Ya')?'Seumur Hidup':$izin->berlaku_sampai}}</td>
                        </tr>
                        <tr>
                            <td>Instansi Penerbit</td>
                            <td>{{$izin->instansi_penerbit}}</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>{{$izin->keterangan}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Input</td>
                            <td>{{$izin->created_at}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td>{{$izin->updated_at}}</td>
                        </tr>
                    </tbody>
                </table>


                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Klasifikasi</th>
                        </tr>
                        @foreach($kualifikasiIzinUsaha as $k => $kui)
                        <tr>
                            <td>{{$k+1}}</td>
                            <td>{{$kui->kualifikasi_bidang->parent->nama_kualifikasi}}</td>
                            <td>{{$kui->nama_kualifikasi}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection