@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('pengalaman.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Detail Pengalaman
                @if($pengalaman->verified_id!=null)    
                    <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                @endif
            </div>
            <div class="card-body">     
                @if($pengalaman->verified_id!=null)           
                <div class="verified-by">
                    <i class="ti ti-check-box"></i>
                    Diverifikasi oleh {{$pengalaman->verified->name}} pada {{date('d M Y',strtotime($pengalaman->tgl_verifikasi))}}
                </div>
                @endif
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td style="width:200px">Kategori Bidang</td>
                            <td>{{$pengalaman->kategori_pekerjaan->nama_kategori}}</td>
                        </tr>
                        <tr>
                            <td>Status Dokumen</td>
                            <td>{{$pengalaman->status_dokumen}}</td>
                        </tr>
                        <tr>
                            <td>Nama Kontrak</td>
                            <td>{{$pengalaman->nama_kontrak}}</td>
                        </tr>
                        <tr>
                            <td>Lingkup Pekerjaan</td>
                            <td>{{$pengalaman->lingkup_pekerjaan}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pelaksanaan Kontrak</td>
                            <td>{{$pengalaman->pelaksanaan_kontrak}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Selesai Kontrak</td>
                            <td>{{$pengalaman->selesai_kontrak}}</td>
                        </tr>
                        <tr>
                            <td>Serah Terima Pekerjaan</td>
                            <td>{{$pengalaman->serah_terima_pekerjaan}}</td>
                        </tr>
                        <tr>
                            <td>Presentase Pekerjaan</td>
                            <td>{{$pengalaman->presentase_pekerjaan}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Input Progress</td>
                            <td>{{$pengalaman->tanggal_progress}}</td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>{{$pengalaman->keterangan}}</td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td>{{$pengalaman->nama_alamat_proyek}}</td>
                        </tr>
                        <tr>
                            <td>Instansi Pengguna</td>
                            <td>{{$pengalaman->instansi_pengguna}}</td>
                        </tr>
                        <tr>
                            <td>Alamat Instansi</td>
                            <td>{{$pengalaman->alamat_instansi}}</td>
                        </tr>
                        <tr>
                            <td>Telpon Instansi</td>
                            <td>{{$pengalaman->telpon_instansi}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Input</td>
                            <td>{{$pengalaman->created_at}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td>{{$pengalaman->updated_at}}</td>
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
                        @foreach($kualifikasiPengalaman as $k => $kui)
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