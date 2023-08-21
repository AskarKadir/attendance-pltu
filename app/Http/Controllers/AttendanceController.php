<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $admin = auth()->user()->is_admin;
        if ($admin == false) {
            $attendances = Attendance::where('user_id', auth()->user()->id)
                ->paginate(10);

            return view('attendance.index', compact('attendances', 'admin'));
        }
        $search = request('search');
        if ($search) {
            $attendances = Attendance::whereHas('user', function ($query) use ($search) {
                $query->where('status', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            })
                ->orderBy('created_at', 'desc')
                ->paginate(20)
                ->withQueryString();
        } else {
            $attendances = Attendance::where('user_id', '!=', '1')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('attendance.index', compact('attendances', 'admin'));
    }

    public function sakit(Attendance $attendance)
    {
        if (auth()->user()->is_admin == true) {
            $attendance->update([
                'status' => 'sakit'
            ]);
            return redirect()->route('attendance.index')->with('success', 'Status has been updated successfully!');
        } else {
            return redirect()->route('attendance.index')->with('danger', 'Failed when update status!');

        }
    }
    public function hadir(Attendance $attendance)
    {
        if (auth()->user()->is_admin == true) {
            $attendance->update([
                'status' => 'hadir'
            ]);
            return redirect()->route('attendance.index')->with('success', 'Status has been updated successfully!');
        } else {
            return redirect()->route('attendance.index')->with('danger', 'Failed when update status!');

        }
    }
    public function izin(Attendance $attendance)
    {
        if (auth()->user()->is_admin == true) {
            $attendance->update([
                'status' => 'izin'
            ]);
            return redirect()->route('attendance.index')->with('success', 'Status has been updated successfully!');
        } else {
            return redirect()->route('attendance.index')->with('danger', 'Failed when update status!');

        }
    }
    public function absen(Attendance $attendance)
    {
        if (auth()->user()->is_admin == true) {
            $attendance->update([
                'status' => 'absen'
            ]);
            return redirect()->route('attendance.index')->with('success', 'Status has been updated successfully!');
        } else {
            return redirect()->route('attendance.index')->with('danger', 'Failed when update status!');

        }
    }
}