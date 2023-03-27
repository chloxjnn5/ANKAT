<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\VerifikasiEmailUntukRegistrasiPengaduanMasyarakat;
use App\Models\Masyarakat;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        // $from = $request->from . ' ' . '00:00:00';
        // $to = $request->to . ' ' . '23:59:59';
        $total = Pengaduan::all()->count();

        $pending = Pengaduan::where('pengaduan.status','=','0')->get()->count();
        $proses = Pengaduan::where('pengaduan.status', 'proses')->get()->count();
        $verifikasi = Pengaduan::where('pengaduan.status', 'selesai')->get()->count();

        // $pengaduan = Pengaduan::where('pengaduan')->orderBy('tgl_pengaduan')-get();
        $pengaduan = Pengaduan::where([['status', '!=', '0',]])->orderBy('tgl_pengaduan', 'desc')->get();


        return view('user.landing', ['total' => $total, 'pending' => $pending, 'proses' => $proses, 'verifikasi' => $verifikasi, 'pengaduan' => $pengaduan]);
    }

    public function login(Request $request)
    {
        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $email = Masyarakat::where('email', $request->username)->first();

            if (!$email) {
                return redirect()->back()->with(['pesan' => 'Email tidak terdaftar']);
            }

            $password = Hash::check($request->password, $email->password);

            if (!$password) {
                return redirect()->back()->with(['pesan' => 'Password tidak sesuai']);
            }

            if (Auth::guard('masyarakat')->attempt(['email' => $request->username, 'password' => $request->password])) {
                // Jika login berhasil
                return redirect('/laporan');
            } else {
                // Jika login gagal
                return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
            }
        } else {
            $username = Masyarakat::where('username', $request->username)->first();

            if (!$username) {
                return redirect()->back()->with(['pesan' => 'Username tidak terdaftar']);
            }

            $password = Hash::check($request->password, $username->password);

            if (!$password) {
                return redirect()->back()->with(['pesan' => 'Password tidak sesuai']);
            }

            if (Auth::guard('masyarakat')->attempt(['username' => $request->username, 'password' => $request->password])) {
                // Jika login berhasil
                return redirect('/laporan');
            } else {
                // Jika login gagal
                return redirect()->back()->with(['pesan' => 'Akun tidak terdaftar!']);
            }
        }
    }

    public function formRegister()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $data = $request->all();

        $validate = Validator::make($data, [
            'nik' => ['required', 'unique:masyarakat', 'min:16'],
            'nama' => ['required', 'string'],
            'jk' => ['required', 'in:pria,wanita,tidakmenyebutkan'],
            'alamat' => ['required', 'string'],
            'email' => ['required', 'email', 'string', 'unique:masyarakat'],
            'username' => ['required', 'string', 'regex:/^\S*$/u', 'unique:masyarakat'],
            'password' => ['required', 'min:6'],
            'telp' => ['required'],
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $email = Masyarakat::where('email', $request->username)->first();

        if ($email) {
            return redirect()->back()->with(['pesan' => 'Email sudah terdaftar'])->withInput(['email' => 'asd']);
        }

        $username = Masyarakat::where('username', $request->username)->first();

        if ($username) {
            return redirect()->back()->with(['pesan' => 'Username sudah terdaftar'])->withInput(['username' => null]);
        }

        Masyarakat::create([
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'jk' => $data['jk'],
            'alamat' => $data['alamat'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'telp' => $data['telp'],
        ]);


        return redirect()->route('pekat.index');
    }

    public function logout()
    {
        Auth::guard('masyarakat')->logout();

        return redirect()->route('pekat.index');
    }

    public function storePengaduan(Request $request)
    {
        if (!Auth::guard('masyarakat')->user()) {
            return redirect()->back()->with(['pesan' => 'Login dibutuhkan!'])->withInput();
        }

        $data = $request->all();

        $validate = Validator::make($data, [
            'judul_laporan' => ['required'],
            'isi_laporan' => ['required'],
            'tgl_kejadian' => ['required'],
            'lokasi_kejadian' => ['required'],
            'foto' => ['nullable', 'file', 'mimes:jpg']
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if ($request->file('foto')) {
            $data['foto'] = $request->file('foto')->store('assets/pengaduan', 'public');
        }

        date_default_timezone_set('Asia/Bangkok');

        $pengaduan = Pengaduan::create([
            'tgl_pengaduan' => date('Y-m-d h:i:s'),
            'nik' => Auth::guard('masyarakat')->user()->nik,
            'judul_laporan' => $data['judul_laporan'],
            'isi_laporan' => $data['isi_laporan'],
            'tgl_kejadian' => $data['tgl_kejadian'],
            'lokasi_kejadian' => $data['lokasi_kejadian'],
            'foto' => $data['foto'] ?? '',
            'status' => '0',
        ]);

        if ($pengaduan) {
            return redirect()->route('pekat.laporan', 'me')->with(['pengaduan' => 'Berhasil terkirim!', 'type' => 'success']);
        } else {
            return redirect()->back()->with(['pengaduan' => 'Gagal terkirim!', 'type' => 'danger']);
        }
    }

    public function laporan($siapa = '')
    {
        $pending = Pengaduan::where([['nik', Auth::guard('masyarakat')->user()->nik], ['status', '=', '0']])->get()->count();
        $proses = Pengaduan::where([['nik', Auth::guard('masyarakat')->user()->nik], ['status', 'proses']])->get()->count();
        $selesai = Pengaduan::where([['nik', Auth::guard('masyarakat')->user()->nik], ['status', 'selesai']])->get()->count();
        $verifikasi = Pengaduan::where([['nik', Auth::guard('masyarakat')->user()->nik], ['verifikasi', true]])->get()->count();

        $hitung = [$verifikasi, $pending, $proses, $selesai];

        if ($siapa == 'me') {
            $pengaduan = Pengaduan::where('nik', Auth::guard('masyarakat')->user()->nik)->orderBy('tgl_pengaduan', 'desc')->get();

            return view('user.laporan', ['pengaduan' => $pengaduan, 'hitung' => $hitung, 'siapa' => $siapa]);
        } else {
            $pengaduan = Pengaduan::where([['nik', '!=', Auth::guard('masyarakat')->user()->nik], ['status', '!=', '0']])->orderBy('tgl_pengaduan', 'desc')->get();

            return view('user.laporan', ['pengaduan' => $pengaduan, 'hitung' => $hitung, 'siapa' => $siapa]);
        }
    }
}
