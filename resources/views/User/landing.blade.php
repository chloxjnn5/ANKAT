@extends('layouts.user')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                    <img src="{{ asset('assets/img/desacibeureum.png') }}" width="70" height="70" alt="no img">
                    <a class="navbar-brand" href="{{ route('pekat.index') }}">
                        <h4 class="semi-bold mb-0 text-white mt-3">ANKAT</h4>
                        <p class="italic mt-0 text-white">Pengaduan Masyarakat Desa Cibeureum</p>
                    </a>
                    <a class="navbar-brand" href="#">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        @if (Auth::guard('masyarakat')->check())
                            <ul class="navbar-nav text-center ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link ml-3 text-white" href="{{ route('pekat.laporan') }}">Laporan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ml-3 text-white" href="{{ route('pekat.logout') }}"
                                        style="text-decoration: underline">Logout</a>
                                </li>
                            </ul>
                        @else
                            <ul class="navbar-nav text-center ml-auto">
                                <li class="nav-item mr-4">
                                    <button class="btn text-white" type="button" class="btn btn-light">BERANDA</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn btn-outline-secondary text-white" type="button" data-toggle="modal" data-target="#loginModal">MASUK</button>
                                </li>
                                <!-- <li></li> -->
                                <!-- <li class="nav-item">
                                        <a href="{{ route('pekat.formRegister') }}" class="btn btn-outline-navy">Daftar</a>
                                    </li> -->
                            </ul>
                        @endauth
                </div>
            </div>
        </div>
    </nav>

</section>
<img src="{{ asset('assets/img/bannerr.png') }}" class="w-100" alt="no img">

{{-- Section Card Pengaduan --}}
{{-- @if (Auth::guard('masyarakat')->check())
    <div class="row justify-content-center">
        <div class="col-lg-6 col-10 col">
            <div class="content shadow">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif

                @if (Session::has('pengaduan'))
                    <div class="alert alert-{{ Session::get('type') }}">{{ Session::get('pengaduan') }}</div>
                @endif

                <h2 class="medium-2 text-center text-black mb-4">Form Laporan Pengaduan</h2>

                <div class="card mb-3 text-center medium">Tulis Laporan Disini!</div>
                <form action="{{ route('pekat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="text" value="{{ old('judul_laporan') }}" name="judul_laporan"
                            placeholder="Masukkan Judul Laporan" class="form-control text-center">
                    </div>
                    <div class="form-group">
                        <textarea name="isi_laporan" placeholder="Masukkan Isi Laporan" class="form-control text-center" rows="4">{{ old('isi_laporan') }}</textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" value="{{ old('tgl_kejadian') }}" name="tgl_kejadian"
                            placeholder="Pilih Tanggal Kejadian" class="form-control text-center"
                            onfocusin="(this.type='date')" onfocusout="(this.type='text')">
                    </div>
                    <div class="form-group">
                        <textarea name="lokasi_kejadian" id="latlang" rows="3" class="form-control mb-3 text-center"
                            placeholder="Lokasi Kejadian">{{ old('lokasi_kejadian') }}</textarea>
                    </div>

                    <div class="form-group">
                        <input type="file" name="foto" class="form-control" id="inp">
                    </div>
                    <button type="submit" class="btn btn-custom mt-2 text-center">Kirim</button>
                </form>
            </div>
        </div>
    </div>
@endif
<br><br><br><br><br><br><br> --}}
{{-- Section Hitung Pengaduan --}}
<div class="containerr">
    <div class="row text-center mb-1 pb-2" style="gap: 2rem;">
        <div class="col bg-navy rounded d-flex align-items-center" style="gap: 3rem; padding: 15px;">
            <i class='bx bxs-report bx-md text-info ml-2'></i>
            <div>
                <p class="italic mb-0 medium text-white">Total Laporan</p>
                <div class="text-center medium text-white">
                    {{ $total }}
                </div>
            </div>
        </div>
        <div class="col bg-navy rounded d-flex align-items-center" style="gap: 4.5rem">
            <i class='bx bxs-comment-dots bx-md text-danger ml-2'></i>
            <div>
                <p class="italic mb-0 medium text-white">Pending</p>
                <div class="text-center medium text-white">
                {{ $pending }}
                </div>
            </div>
        </div>
        <div class="col bg-navy rounded d-flex align-items-center" style="gap: 4.5rem">
            <i class='bx bx-loader bx-md text-warning ml-2'></i>
            <div>
                <div class="text-center medium text-white">
                <p class="italic mb-0 medium text-white">Proses</p>
                {{ $proses }}
                </div>
            </div>
        </div>
        <div class="col bg-navy rounded d-flex align-items-center" style="gap: 4.5rem">
            <i class='bx bx-check-circle bx-md text-success ml-2'></i>
            <div>
                <p class="italic mb-0 medium text-white">Selesai</p>
                <div class="text-center medium text-white">
                {{ $verifikasi }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content shadow" style="margin: 5rem 2rem; margin-bottom: 10rem;">
    <table id="pengaduanTable" class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Isi Laporan</th>
                <th>Status</th>
                <th>Tanggal Tanggapan</th>
                <th>Tanggapan</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengaduan as $k => $v)
                <tr>
                    <td>{{ $k += 1 }}</td>
                    <td>{{ $v->tgl_pengaduan }}</td>
                    <td>{{ $v->user->nama }}</td>
                    <td>{{ $v->isi_laporan }}</td>
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
                        @if ($v->tanggapan != null)
                            {{ $v->tanggapan->tgl_tanggapan }}
                        @endif
                    </td>
                    <td>
                        @if ($v->tanggapan != null)
                            {{ $v->tanggapan->tanggapan }}
                        @endif
                    </td>
                    <td>
                        @if ($v->foto != null)
                            <img src="{{ asset('/storage/' . $v->foto) }}" alt="{{ 'Gambar ' . $v->judul_laporan }}"
                                class="img">
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

{{-- Modal --}}
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="mt-3">Masuk terlebih dahulu</h3>
                <p>Silahkan masuk menggunakan akun yang sudah didaftarkan.</p>
                <div class="row">
                </div>
                <div class="text-center">
                </div>
                <form action="{{ route('pekat.login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username atau Email</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <a href="{{ route('pekat.formRegister') }}">Belum punya akun?</a>
                    <button type="submit" class="btn btn-navy text-white mt-3" style="width: 100%">MASUK</button>
                </form>
                @if (Session::has('pesan'))
                    <div class="alert alert-danger mt-2">
                        {{ Session::get('pesan') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
{{-- Footer --}}
<div class="mt-5 mb-0">
    <hr>
    <div class="text-center">
        <p class="text-secondary">© Copyright ANKAT </p>
    </div>
</div>
@endsection

@section('js')
@if (Session::has('pesan'))
    <script>
        $('#loginModal').modal('show');
    </script>
@endif
@endsection
