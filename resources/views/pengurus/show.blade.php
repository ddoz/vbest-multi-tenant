@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('pengurus.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Detail Pengurus
                @if($penguru->verified_id!=null)    
                    <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                @endif
            </div>
            <div class="card-body">     
                @if($penguru->verified_id!=null)           
                <div class="verified-by">
                    <i class="ti ti-check-box"></i>
                    Diverifikasi oleh {{$penguru->verified->name}} pada {{date('d M Y',strtotime($penguru->tgl_verifikasi))}}
                </div>
                @endif
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td style="width:200px">Jenis Kepengurusan</td>
                            <td>{{$penguru->jenis_kepengurusan->nama}}</td>
                        </tr>
                        <tr>
                            <td>Status Dokumen</td>
                            <td>{{$penguru->status_dokumen}}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>{{$penguru->nama}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Identitas</td>
                            <td>{{$penguru->nomor_identitas}}</td>
                        </tr>
                        <tr>
                            <td>NPWP</td>
                            <td>{{$penguru->npwp}}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>{{$penguru->alamat}}</td>
                        </tr>
                        <tr>
                            <td>Provinsi</td>
                            <td>{{$penguru->provinsi->provinsi}}</td>
                        </tr>
                        <tr>
                            <td>Kabupaten</td>
                            <td>{{$penguru->kabupaten->kabupaten}}</td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>{{$penguru->kecamatan->kecamatan}}</td>
                        </tr>
                        <tr>
                            <td>Kelurahan</td>
                            <td>{{$penguru->kelurahan->kelurahan}}</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>{{$penguru->jabatan}}</td>
                        </tr>
                        <tr>
                            <td>Menjabat Sejak</td>
                            <td>{{$penguru->menjabat_sejak}}</td>
                        </tr>
                        <tr>
                            <td>Menjabat Sampai</td>
                            <td>{{$penguru->menjabat_sampai}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Input</td>
                            <td>{{$penguru->created_at}}</td>
                        </tr>
                        <tr>
                            <td>Keterangan Tambahan</td>
                            <td>{{$penguru->keterangan_tambahan}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td>{{$penguru->updated_at}}</td>
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