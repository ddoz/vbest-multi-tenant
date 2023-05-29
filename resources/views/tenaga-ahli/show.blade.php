@extends('layout/app')

@section('content')
    <div class="col-sm-10">
        <div class="card card-wrapper">
            <div class="card-header">
                <a href="{{route('tenaga-ahli.index')}}" class="btn btn-outline-warning">
                    <i class="ti ti-angle-left"></i> Kembali
                </a>
                Detail Tenaga Ahli
                @if($tenaga_ahli->verified_id!=null)    
                    <img src="{{asset('assets/img/verified.png')}}" width="17px" class="ml-1">
                @endif
            </div>
            <div class="card-body">     
                @if($tenaga_ahli->verified_id!=null)           
                <div class="verified-by">
                    <i class="ti ti-check-box"></i>
                    Diverifikasi oleh {{$tenaga_ahli->verified->name}} pada {{date('d M Y',strtotime($tenaga_ahli->tgl_verifikasi))}}
                </div>
                @endif
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td style="width:200px">Jenis Tenaga Ahli</td>
                            <td>{{$tenaga_ahli->jenis_tenaga_ahli->nama}}</td>
                        </tr>
                        <tr>
                            <td>Status Dokumen</td>
                            <td>{{$tenaga_ahli->status_dokumen}}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>{{$tenaga_ahli->nama}}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>{{$tenaga_ahli->jenis_kelamin}}</td>
                        </tr>
                        <tr>
                            <td>KTP / Nomor Paspor</td>
                            <td>{{$tenaga_ahli->nomor_identitas}}</td>
                        </tr>
                        <tr>
                            <td>NPWP</td>
                            <td>{{$tenaga_ahli->npwp}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>{{$tenaga_ahli->tanggal_lahir}}</td>
                        </tr>
                        <tr>
                            <td>Kewarganegaraan</td>
                            <td>{{$tenaga_ahli->kewarganegaraan->nama_kewarganegaraan}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{$tenaga_ahli->email}}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>{{$tenaga_ahli->alamat}}</td>
                        </tr>
                        <tr>
                            <td>Provinsi</td>
                            <td>{{$tenaga_ahli->provinsi->provinsi}}</td>
                        </tr>
                        <tr>
                            <td>Kabupaten</td>
                            <td>{{$tenaga_ahli->kabupaten->kabupaten}}</td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>{{$tenaga_ahli->kecamatan->kecamatan}}</td>
                        </tr>
                        <tr>
                            <td>Kelurahan</td>
                            <td>{{$tenaga_ahli->kelurahan->kelurahan}}</td>
                        </tr>
                        <tr>
                            <td>Pendidikan Akhir</td>
                            <td>{{$tenaga_ahli->pendidikan_akhir}}</td>
                        </tr>
                        <tr>
                            <td>Profesi Keahlian</td>
                            <td>{{$tenaga_ahli->profesi_keahlian}}</td>
                        </tr>
                        <tr>
                            <td>Lama Pengalaman Kerja (Tahun)</td>
                            <td>{{$tenaga_ahli->lama_pengalaman}}</td>
                        </tr>
                        <tr>
                            <td>Status Kepegawaian</td>
                            <td>{{$tenaga_ahli->status_kepegawaian}}</td>
                        </tr>
                        <tr>
                            <td>Riwayat Penyakit</td>
                            <td>{{$tenaga_ahli->riwayat_penyakit}}</td>
                        </tr>
                        <tr>
                            <td>Keterangan Tambahan</td>
                            <td>{{$tenaga_ahli->keterangan_tambahan}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td>{{$tenaga_ahli->updated_at}}</td>
                        </tr>
                        <tr>
                            <td>Lampiran Dokumen</td>
                            <td><a href=""> <i class="ti ti-download"></i> Download Lampiran</a></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="card card-body">
                        <h5>Sertifikasi</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Jenis Sertifikat</td>
                                    <td>Lampiran</td>
                                    <td>Bidang</td>
                                    <td>Tingkatan</td>
                                    <td>Masa Berlaku (Diterbitkan)</td>
                                    <td>Masa Berlaku (Berakhir)</td>
                                    <td>Penerbit</td>
                                </tr>
                                @foreach($sertifikasi as $srt)
                                <tr>
                                    <td>{{$srt->jenis_sertifikat}}</td>
                                    <td><a href=""> <i class="ti ti-download"></i> Download Lampiran</a></td>
                                    <td>{{$srt->bidang}}</td>
                                    <td>{{$srt->tingkatan}}</td>
                                    <td>{{$srt->diterbitkan}}</td>
                                    <td>{{$srt->berakhir}}</td>
                                    <td>{{$srt->penerbit}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4 card card-body">
                        <h5>Pengalaman</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Tahun</td>
                                    <td>Uraian</td>
                                </tr>
                                @foreach($pengalaman as $srt)
                                <tr>
                                    <td>{{$srt->tahun}}</td>
                                    <td>{{$srt->uraian}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4 card card-body">
                        <h5>Pendidikan</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Tahun</td>
                                    <td>Uraian</td>
                                </tr>
                                @foreach($pendidikan as $srt)
                                <tr>
                                    <td>{{$srt->tahun}}</td>
                                    <td>{{$srt->uraian}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4 card card-body">
                        <h5>Kemampuan Bahasa</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Uraian</td>
                                </tr>
                                @foreach($kemampuanBahasa as $srt)
                                <tr>
                                    <td>{{$srt->uraian}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection