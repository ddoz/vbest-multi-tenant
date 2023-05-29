@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('laba-rugi.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Detail Laporan Keuangan - Laba Rugi
                @if($laba_rugi->verified_id!=null)    
                    <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                @endif
            </div>
            <div class="card-body">     
                @if($laba_rugi->verified_id!=null)           
                <div class="verified-by">
                    <i class="ti ti-check-box"></i>
                    Diverifikasi oleh {{$laba_rugi->verified->name}} pada {{date('d M Y',strtotime($laba_rugi->tgl_verifikasi))}}
                </div>
                @endif
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Status Dokumen</td>
                            <td>{{$laba_rugi->status_dokumen}}</td>
                        </tr>
                        <tr>
                            <td>Tahun</td>
                            <td>{{$laba_rugi->tahun}}</td>
                        </tr>
                        <tr>
                            <td>Pendapatan</td>
                            <td>{{$laba_rugi->pendapatan}}</td>
                        </tr>
                        <tr>
                            <td>Laba Kotor</td>
                            <td>{{$laba_rugi->laba_kotor}}</td>
                        </tr>
                        <tr>
                            <td>Laba Bersih</td>
                            <td>{{$laba_rugi->laba_bersih}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Input</td>
                            <td>{{$laba_rugi->created_at}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td>{{$laba_rugi->updated_at}}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection