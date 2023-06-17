<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('fail'))
            <div class="alert alert-danger alertstatus" role="alert">
                {{ session('fail') }}
            </div>
        @endif


            <div class="card">
                <div class="card-header">Profil</div>                   
                <div class="card-body">
                    
                    <form action="{{route('profil.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" class="form-control" value="{{Auth::user()->email}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" value="{{$profil->name}}" required name="name">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4 mb-2">
                <div class="card-header">Ubah Password</div>                   
                <div class="card-body">
                    
                    <form action="{{route('profil.password')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Password Lama</label>
                            <input type="password" class="form-control" required name="old">
                            @if ($errors->has('old'))
                                <span class="text-danger">{{ $errors->first('old') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Password Baru</label>
                            <input type="password" class="form-control" required name="new">
                            @if ($errors->has('new'))
                                <span class="text-danger">{{ $errors->first('new') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>