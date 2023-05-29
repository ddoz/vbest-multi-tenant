@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('akta.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Detail Akta Perusahaan
                @if($aktum->verified_id!=null)    
                    <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                @endif
            </div>
            <div class="card-body">     
                @if($aktum->verified_id!=null)           
                <div class="verified-by">
                    <i class="ti ti-check-box"></i>
                    Diverifikasi oleh {{$aktum->verified->name}} pada {{date('d M Y',strtotime($aktum->tgl_verifikasi))}}
                </div>
                @endif
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td style="width:200px">Jenis Akta</td>
                            <td>{{$aktum->jenis_akta}}</td>
                        </tr>
                        <tr>
                            <td>Status Dokumen</td>
                            <td>{{$aktum->status_dokumen}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Akta</td>
                            <td>{{$aktum->no_akta}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Terbit</td>
                            <td>{{$aktum->tanggal_terbit}}</td>
                        </tr>
                        <tr>
                            <td>Notaris</td>
                            <td>{{$aktum->nama_notaris}}</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>{{$aktum->keterangan}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Input</td>
                            <td>{{$aktum->created_at}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td>{{$aktum->updated_at}}</td>
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