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
        // dd($setting);
        return view('setting.index', compact('setting'));
    }

    public function store(Request $request, Clock $clock)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        $start_time = Carbon::parse($request->start_time)->format('H:i:s');
        $end_time = Carbon::parse("18:00")->format('H:i:s');
        // dd($end_time);

        // // Check if data already exists
        $exist = Clock::where('id', 1)->get()->first();
        if (!$exist) {
            Clock::create([
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);
            // dd($start_time, $end_time, $exist);
            return redirect()->route('setting.index')->with('success', 'Setting Updated');
        }
        else {
            $exist->update([
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);
            // dd($start_time, $end_time, $exist);
            return redirect()->route('setting.index')->with('success', 'Setting Update');
        }
    }

    // public function update(Request $request, Clock $clock)
    // {
    //     // Validate the request data
    //     $request->validate([
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i',
    //     ]);

    //     // Convert start_time and end_time to 'H:i:s' format
    //     try {
    //         $start_time = Carbon::createFromFormat('H:i', $request->start_time)->format('H:i:s');
    //         $end_time = Carbon::createFromFormat('H:i', $request->end_time)->format('H:i:s');
    //     } catch (\Exception $e) {
    //         return redirect()->route('setting.index')->with('error', 'Setting same as before');
    //     }

    //     $clock->update([
    //         'start_time' => $start_time,
    //         'end_time' => $end_time,
    //     ]);
    // }
}
