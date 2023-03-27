@extends('layouts.user')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/laporan.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

<style>

    .notification {
        padding: 14px;
        text-align: center;
        background: #f4b704;
        color: #fff;
        font-weight: 300;
    }

    .btn-white {
        background: #fff;
        color: #000;
        text-transform: uppercase;
        padding: 0px 25px 0px 25px;
        font-size: 14px;
    }
    img {
            width: 70px;
        }
</style>
@endsection

@section('title', 'ANKAT')

@section('content')
{{-- Section Header --}}
<section class="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-navy">
        <div class="container">
            <div class="container-fluid">
                <img src="{{ asset('assets/img/desacibeureum.png')}}" width ="70" height="70" alt="no img">
                <a class="navbar-brand" href="{{ route('pekat.index') }}">
                    <h4 class="semi-bold mb-0 text-white mt-3">ANKAT</h4>
                    <p class="italic mt-0 text-white">Pengaduan Masyarakat Desa Cibeureum</p>
                </a>
                {{-- <a class="navbar-brand" href="{{ route('pekat.index') }}">
                    <h4 class="semi-bold mb-0 text-white">ANKAT</h4>
                </a> --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    @if(Auth::guard('masyarakat')->check())
                    <ul class="navbar-nav text-center ml-auto">
                        <li class="nav-item">
                            <a class="nav-link ml-3 text-white">Hi, {{ Auth::guard('masyarakat')->user()->nama }}!</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ml-3 btn btn-outline-logout" href="{{ route('pekat.logout') }}">Logout</a>
                        </li>
                    </ul>
                    @else
                    <ul class="navbar-nav text-center ml-auto">
                        <li class="nav-item">
                            <button class="btn text-white" type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#loginModal">Masuk</button>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pekat.formRegister') }}" class="btn btn-outline-navy">Daftar</a>
                        </li>
                    </ul>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

</section>
{{-- Section Card --}}
<div class="container" style="margin-top: 13rem;">
        <div class="row justify-content-center">
        <div class="col-lg-3 col-md-12 col-sm-12 col-12 col">
            <div class="content content-top shadow">
                <img src="{{ asset('assets/img/user.png') }}" alt="user profile" class="photo" style="width: 3rem; height: 3rem;">
                <div class="ml-5">
                    <h5><a style="color: #000" href="#">{{ Auth::guard('masyarakat')->user()->nama }}</a></h5>
                    <p class="text-dark">{{ Auth::guard('masyarakat')->user()->username }}</p>
                </div>
            </div>
        </div>
        <br><br><br><br><br><br><br><br>
        <div class="row justify-content-center">
            <div class="col-lg-13 col-md-12 col">
                <div class="content content-top shadow">
                        {{-- <img src="{{ asset('assets/img/user.png') }}" alt="user profile" class="photo" style="width: 4rem; height: 4rem; margin: 0 5rem;">
                        <div class="self-align ml-5 mt-2">
                            <h5><a style="color: #000" href="#">{{ Auth::guard('masyarakat')->user()->nama }}</a></h5>
                            <p class="text-dark">{{ Auth::guard('masyarakat')->user()->username }}</p>
                        </div> --}}
                        <div class="row text-center">
                            <div class="col">
                                <p class="italic mb-0">Terverifikasi</p>
                                <div class="text-center">
                                    {{ $hitung[0] }}
                                </div>
                            </div>
                            <div class="col">
                                <p class="italic mb-0">Pending</p>
                                <div class="text-center">
                                    {{ $hitung[1] }}
                                </div>
                            </div>
                            <div class="col">
                                <p class="italic mb-0">Proses</p>
                                <div class="text-center">
                                    {{ $hitung[2] }}
                                </div>
                            </div>
                            <div class="col">
                                <p class="italic mb-0">Selesai</p>
                                <div class="text-center">
                                    {{ $hitung[3] }}
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12 col-sm-12 col-12 col">
            <div class="content content-top shadow">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
                @endif
                @if (Session::has('pengaduan'))
                <div class="alert alert-{{ Session::get('type') }}">{{ Session::get('pengaduan') }}</div>
                @endif
                <h2 class="medium-2 text-center text-black mb-4">Form Laporan Pengaduan</h2>
                <div class="card mb-3 text-center">Sampaikan Pengaduan dan Aspirasi Anda disini</div>
                <form action="{{ route('pekat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="text" value="{{ old('judul_laporan') }}" name="judul_laporan" placeholder="Masukkan Judul Laporan"
                            class="form-control text-left">
                    </div>
                    <div class="form-group">
                        <textarea name="isi_laporan" placeholder="Masukkan Isi Laporan" class="form-control text-left"
                            rows="4">{{ old('isi_laporan') }}</textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" value="{{ old('tgl_kejadian') }}" name="tgl_kejadian" placeholder="Pilih Tanggal Kejadian" class="form-control text-left"
                            onfocusin="(this.type='date')" onfocusout="(this.type='text')">
                    </div>
                    <div class="form-group">
                        <textarea name="lokasi_kejadian" rows="3" class="form-control text-left" placeholder="Lokasi Kejadian">{{ old('lokasi_kejadian') }}</textarea>
                    </div>

                    <div class="form-group">
                        <input type="file" name="foto" class="form-control" id="inp">
                    </div>
                    <button type="submit" class="btn btn-custom mt-2">Kirim</button>
                </form>
            </div>
        </div>

    </div>

    <div class="row justify-content-center" style="margin-top: 5rem; margin-bottom: 5rem;">
        <div class="col-lg-3">
            <a class="d-inline tab {{ $siapa != 'me' ? 'tab-active' : ''}} mr-4" href="{{ route('pekat.laporan') }}">
                Semua
            </a>
            <a class="d-inline tab {{ $siapa == 'me' ? 'tab-active' : ''}}" href="{{ route('pekat.laporan', 'me') }}">
                Laporan Saya
            </a>
            <hr>
        </div>

        <table id="pengaduanTable" class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Isi Laporan</th>
                <th>Tanggal Tanggapan</th>
                <th>Tanggapan</th>
                <th>Status</th>
                <th>Verifikasi</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengaduan as $k => $v)
            <tr>
                <td>{{ $k += 1 }}</td>
                <td>{{ $v->tgl_pengaduan }}</td>
                <td>{{ $v->user->nama}}</td>
                <td>{{ $v->isi_laporan }}</td>
                <td>
                @if ($v->tanggapan != null)
                        <p class="tanggapan-laporan">{{ $v->tanggapan->tgl_tanggapan }}</p>
                    @endif
                </td>
                <td>
                @if ($v->tanggapan != null)
                    <p class="light">{{ $v->tanggapan->tanggapan }}</p>

                    @endif
                </td>
                <td>
                    @if ($v->status == '0')
                        <a href="" class="badge badge-danger">Pending</a>
                    @elseif($v->status == 'proses')
                        <a href="" class="badge badge-warning text-white">Proses</a>
                    @else
                        <a href="" class="badge badge-success">Selesai</a>
                    @endif
                </td>
                <td>
                    @if (!$v->verifikasi)
                        Belum diverifikasi
                    @else
                        Sudah diverifikasi
                    @endif
                </td>
                <td>
                    @if ($v->foto != null)
                        <img src="{{ asset('/storage/' . $v->foto) }}" alt="{{ 'Gambar '.$v->judul_laporan }}" class="img">
                    @endif

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
{{-- Footer --}}
{{-- <div class="mt-5 mb-0">
    <hr>
    <div class="text-center">
        <p class="text-secondary">© Copyright ANKAT </p>
    </div>
</div> --}}
@endsection

@section('js')
@if (Session::has('pesan'))
<script>`
    $('#loginModal').modal('show');

</script>
@endif
@endsection
