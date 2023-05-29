@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('laba-rugi.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Detail Laporan Keuangan - Neraca
                @if($neraca->verified_id!=null)    
                    <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                @endif
            </div>
            <div class="card-body">     
                @if($neraca->verified_id!=null)           
                <div class="verified-by">
                    <i class="ti ti-check-box"></i>
                    Diverifikasi oleh {{$neraca->verified->name}} pada {{date('d M Y',strtotime($neraca->tgl_verifikasi))}}
                </div>
                @endif
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Status Dokumen</td>
                            <td>{{$neraca->status_dokumen}}</td>
                        </tr>
                        <tr>
                            <td>Tahun</td>
                            <td>{{$neraca->tahun}}</td>
                        </tr>
                        <tr>
                            <td>Aset</td>
                            <td>{{$neraca->aset}}</td>
                        </tr>
                        <tr>
                            <td>Kewajiban</td>
                            <td>{{$neraca->kewajiban}}</td>
                        </tr>
                        <tr>
                            <td>Modal</td>
                            <td>{{$neraca->modal}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Input</td>
                            <td>{{$neraca->created_at}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td>{{$neraca->updated_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection