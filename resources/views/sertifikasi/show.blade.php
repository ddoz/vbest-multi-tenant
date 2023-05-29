@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('sertifikasi.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Detail Sertifikasi
                @if($sertifikasi->verified_id!=null)    
                    <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                @endif
            </div>
            <div class="card-body">     
                @if($sertifikasi->verified_id!=null)           
                <div class="verified-by">
                    <i class="ti ti-check-box"></i>
                    Diverifikasi oleh {{$sertifikasi->verified->name}} pada {{date('d M Y',strtotime($sertifikasi->tgl_verifikasi))}}
                </div>
                @endif
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td style="width:200px">Jenis Sertifikat</td>
                            <td>{{$sertifikasi->jenis_sertifikat}}</td>
                        </tr>
                        <tr>
                            <td>Status Dokumen</td>
                            <td>{{$sertifikasi->status_dokumen}}</td>
                        </tr>
                        <tr>
                            <td>Nomor</td>
                            <td>{{$sertifikasi->nomor}}</td>
                        </tr>
                        <tr>
                            <td>Seumur Hidup</td>
                            <td>{{$sertifikasi->seumur_hidup}}</td>
                        </tr>
                        <tr>
                            <td>Berlaku Sampai</td>
                            <td>{{$sertifikasi->berlaku_sampai}}</td>
                        </tr>
                        <tr>
                            <td>Instansi Pemberi</td>
                            <td>{{$sertifikasi->instansi_pemberi}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Input</td>
                            <td>{{$sertifikasi->created_at}}</td>
                        </tr>
                        <tr>
                            <td>Keterangan Tambahan</td>
                            <td>{{$sertifikasi->keterangan_tambahan}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td>{{$sertifikasi->updated_at}}</td>
                        </tr>
                        <tr>
                            <td>Lampiran Dokumen</td>
                            <td><a href=""> <i class="ti ti-download"></i> Download Lampiran</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection