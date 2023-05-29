@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('rekening-bank.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Detail Rekening Bank
                @if($rekening_bank->verified_id!=null)    
                    <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                @endif
            </div>
            <div class="card-body">     
                @if($rekening_bank->verified_id!=null)           
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
        </div>
    </div>
@endsection