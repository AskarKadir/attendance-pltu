<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $hadirCount = $this->hadir();
        $sakitCount = $this->sakit();
        $izinCount  = $this->izin();
        $absenCount = $this->absen();
        return view(
            'dashboard',
            [
                'hadirCount' => $hadirCount,
                'sakitCount' => $sakitCount,
                'izinCount'  => $izinCount,
                'absenCount' => $absenCount,
            ]
        );
    }
    public function hadir()
    {
        $today = Carbon::now()->format('Y-m-d');
        $hadir = Attendance::where('status', 'hadir')
            ->whereDate('created_at', $today)
            ->count();
        return $hadir;
    }

    public function sakit()
    {
        $today = Carbon::now()->format('Y-m-d');
        $sakit = Attendance::where('status', 'sakit')
            ->whereDate('created_at', $today)
            ->count();
        return $sakit;
    }

    public function izin()
    {
        $today = Carbon::now()->format('Y-m-d');
        $izin  = Attendance::where('status', 'izin')
            ->whereDate('created_at', $today)
            ->count();
        return $izin;
    }

    public function absen()
    {
        $today = Carbon::now()->format('Y-m-d');
        $absen = Attendance::where('status', 'absen')
            ->whereDate('created_at', $today)
            ->count();
        return $absen;
    }
}