<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Traits\ToStringFormat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Clock;

class AttendanceController extends Controller
{
    public function index()
    {
        $clock = Clock::find(1);
        // parse time to string
        $start_time = Carbon::parse($clock->start_time)->format('H:i:s');
        $admin = auth()->user()->is_admin;
        // dd($clock->start_time);
        if ($admin == false) {
            $attendances = Attendance::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'asc')
                ->paginate(10);


                return view('attendance.index', compact('attendances', 'admin', 'start_time'));
            }
        $search = request('search');
        if ($search) {
            $attendances = Attendance::whereHas('user', function ($query) use ($search) {
                $query->where('status', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%');
            })
                ->orderBy('created_at', 'asc')
                ->paginate(20)
                ->withQueryString();
            } else {
                $attendances = Attendance::where('user_id', '!=', '1')
                ->orderBy('created_at', 'asc')
                ->paginate(10);
            }
        return view('attendance.index', compact('attendances', 'admin', 'start_time'));
    }

    public function create()
    {
        return view('attendance.create');
    }

    public function store(Request $request, Attendance $attendance)
    {
        $user_id = User::where('email', $request->email)->first();
        $status  = $request->status;
        $today   = Carbon::now()->format('Y-m-d'); // Get current date in 'YYYY-MM-DD' format

        $request->validate([
            'email'  => 'required|email',
            'status' => 'required|in:hadir,sakit,izin,absen', // Make sure 'status' is one of these values
        ]);

        $existingAttendance = Attendance::where('user_id', $user_id->id)
            ->whereDate('created_at', $today)
            ->first();

        if ($existingAttendance) {
            return redirect()->route('attendance.index')->with('danger', 'Attendance has been recorded before!');
        }

        $attendance = Attendance::create([
            'user_id' => $user_id->id,
            'status'  => $status,
        ]);
        // dd($status);
        return redirect()->route('attendance.index')->with('success', 'Create Attendance Success!');
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

    public function exportToPdf()
    {
        $admin = auth()->user()->is_admin;

        if ($admin == false) {
            $attendances = Attendance::where('user_id', auth()->user()->id)->get();
            $pdf = PDF::loadView('attendance.pdf', ['attendances' => $attendances]);
            return $pdf->download('attendance_' . auth()->user()->name  . '.pdf');
        } else {
            $search = request('search');
            if ($search) {
                $attendances = Attendance::whereHas('user', function ($query) use ($search) {
                    $query->where('status', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->get();
            } else {
                $attendances = Attendance::where('user_id', '!=', '1')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        $pdf = PDF::loadView('attendance.pdf', compact('attendances', 'admin'));
        if ($search){
            $safeSearch = preg_replace('/[^A-Za-z0-9\-]/', '_', $search);
            $filename = 'attendance_report_' . $safeSearch . '.pdf';
            return $pdf->download($filename);
        }
        return $pdf->download('attendance_report.pdf');
    }
}
