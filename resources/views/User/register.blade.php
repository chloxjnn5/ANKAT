@extends('layouts.user')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    body {
        background: #100F0D;
        font-family: 'Vollkorn', serif;
    }

    .btn-navy {
        background: #000;
        width: 100%;
        color: #fff;
        font-weight: 600;
    }

    .btn-navy:hover {
        background:#000;
        width: 100%;
        color: #fff;
        font-weight: 600;
    }

</style>
@endsection

@section('title', 'Registrasi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card mt-5 mb-5">
                <div class="card-body">
                    <h3 class="text-center mb-4">REGISTRASI</h3>
                    <form action="{{ route('pekat.register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="number" maxLength="16" value="{{ old('nik') }}" name="nik" placeholder="NIK" class="form-control @error('nik') is-invalid @enderror">
                            @error('nik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" value="{{ old('nama') }}" name="nama" placeholder="Nama Lengkap" class="form-control @error('nama') is-invalid @enderror">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select type="text" value="{{ old('jk') }}" name="jk" placeholder="jk" class="form-control @error('jk') is-invalid @enderror">
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="pria">Laki-laki</option>
                                <option value="wanita">Perempuan</option>
                                <option value="tidakmenyebutkan">Tidak Menyebutkan</option>
                            </select>
                            @error('jk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea name="alamat" placeholder="Alamat" class="form-control @error('alamat') is-invalid @enderror" rows="4"></textarea>
                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        </div>
                        {{-- <div class="form-group">
                            <input type="text" value="{{ old('alamat') }}" name="alamat" placeholder="Alamat" class="form-control @error('alamat') is-invalid @enderror">
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <input type="email" value="{{ old('email') }}" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" value="{{ old('username') }}" name="username" placeholder="Username" class="form-control @error('username') is-invalid @enderror">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="number" value="{{ old('telp') }}" name="telp" placeholder="No. Telp" class="form-control @error('telp') is-invalid @enderror">
                            @error('telp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-navy mt-2">DAFTAR</button>
                    </form>
            </div>
            @if (Session::has('pesan'))
                <div class="alert alert-danger my-2">
                    {{ Session::get('pesan') }}
                </div>
            @endif
            <a href="{{ route('pekat.index') }}" class="btn btn-light text-dark" style="width: 100%; font-weight: 600">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
