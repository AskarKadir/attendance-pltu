<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Clock;
use Psy\Formatter\Formatter;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Clock::find(1);
        return view('setting.index', compact('setting'));
    }

    public function store(Request $request, Clock $clock)
    {
        $start_time = Carbon::createFromFormat('H:i', $request->start_time)->format('H:i:s');
        $end_time = Carbon::createFromFormat('H:i', $request->end_time)->format('H:i:s');
        // dd($start_time, $end_time);
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        $checkclock = Clock::find(1);
        if ($checkclock) {
            $setting = Clock::where('id', 1)->update([
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);

        return redirect()->route('setting.index')->with('success', 'Settings saved successfully.');
        } else {
            $setting = Clock::create([
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);
            return redirect()->route('setting.index')->with('success', 'Settings saved successfully.');
        }
    }
}
