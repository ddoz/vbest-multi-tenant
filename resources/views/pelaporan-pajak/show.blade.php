@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('pelaporan-pajak.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Detail Pelaporan Pajak
                @if($pelaporan_pajak->verified_id!=null)    
                    <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                @endif
            </div>
            <div class="card-body">     
                @if($pelaporan_pajak->verified_id!=null)           
                <div class="verified-by">
                    <i class="ti ti-check-box"></i>
                    Diverifikasi oleh {{$pelaporan_pajak->verified->name}} pada {{date('d M Y',strtotime($pelaporan_pajak->tgl_verifikasi))}}
                </div>
                @endif
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td style="width:200px">Jenis Pelaporan</td>
                            <td>{{$pelaporan_pajak->jenis_pelaporan}}</td>
                        </tr>
                        <tr>
                            <td>Status Dokumen</td>
                            <td>{{$pelaporan_pajak->status_dokumen}}</td>
                        </tr>
                        <tr>
                            <td>Masa Tahun Pajak</td>
                            <td>{{$pelaporan_pajak->masa_tahun_pajak}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Bukti Penerimaan Surat</td>
                            <td>{{$pelaporan_pajak->nomor_bukti_surat}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Bukti Penerimaan Surat</td>
                            <td>{{$pelaporan_pajak->tanggal_bukti_surat}}</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>{{$pelaporan_pajak->keterangan}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Input</td>
                            <td>{{$pelaporan_pajak->created_at}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td>{{$pelaporan_pajak->updated_at}}</td>
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