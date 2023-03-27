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
        $from = $request->from . ' ' . '00:00:00';
        $to = $request->to . ' ' . '23:59:59';

        $pengaduan = Pengaduan::whereBetween('tgl_pengaduan', [$from, $to])->get();
        $tanggapan = Tanggapan::where('id_pengaduan', $request->id_pengaduan)->first();


        return view('Admin.Laporan.index', ['pengaduan' => $pengaduan, 'from' => $from, 'to' => $to, 'tanggapan' => $tanggapan]);
    }

    public function cetakLaporan($from, $to)
    {
        $pengaduan = Pengaduan::whereBetween('tgl_pengaduan', [$from, $to])->get();
        // $masyarakat = Masyarakat::whereBetween('nik', [$from, $to])->get();

        $pdf = PDF::loadView('Admin.Laporan.cetak', ['pengaduan' => $pengaduan]);
        $pdf->setPaper([0,0, 1000, 900], 'landscape');

        return $pdf->stream('laporan-pengaduan.pdf');
    }
}
