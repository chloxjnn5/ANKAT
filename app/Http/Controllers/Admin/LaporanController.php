<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\Masyarakat;


use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        return view('Admin.Laporan.index');
    }

    public function getLaporan(Request $request)
    {
        $from = $request->from . ' ' . '';
        $to = $request->to . ' ' . '';

        $pengaduan = Pengaduan::whereBetween('tgl_pengaduan', [$from, $to])->get();
        $tanggapan = Tanggapan::where('id_pengaduan', $request->id_pengaduan)->first();

        return view('Admin.Laporan.index', ['pengaduan' => $pengaduan, 'from' => $from, 'to' => $to, 'tanggapan' => $tanggapan]);
    }

    public function cetakLaporan($from, $to)
    {
        $pengaduan = Pengaduan::whereBetween('tgl_pengaduan', [$from, $to])->get();
        // $masyarakat = Masyarakat::whereBetween('nik', [$from, $to])->get();

        $pdf = PDF::loadView('Admin.Laporan.cetak', ['pengaduan' => $pengaduan, 'from' => $from, 'to' => $to]);
        $customPaper = array(0,0, 1000, 500);
        $pdf->setPaper($customPaper);

        return $pdf->stream('laporan-pengaduan.pdf');
    }
}
