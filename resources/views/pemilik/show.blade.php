@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('pemilik.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Detail Pemilik
                @if($pemilik->verified_id!=null)    
                    <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                @endif
            </div>
            <div class="card-body">     
                @if($pemilik->verified_id!=null)           
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
        </div>
    </div>
@endsection