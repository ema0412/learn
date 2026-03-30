<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $attendance = Attendance::firstOrCreate(
            ['user_id' => $request->user()->id, 'work_date' => $today->toDateString()],
            ['status' => 'off']
        );

        return view('attendance.index', [
            'attendance' => $attendance->load('breaks'),
            'now' => Carbon::now(),
        ]);
    }

    public function clockIn(Request $request)
    {
        $attendance = Attendance::firstOrCreate(
            ['user_id' => $request->user()->id, 'work_date' => now()->toDateString()],
            ['status' => 'off']
        );

        if ($attendance->clock_in_at || $attendance->status === 'done') {
            return back();
        }

        $attendance->update([
            'clock_in_at' => now(),
            'status' => 'working',
        ]);

        return back();
    }

    public function breakStart(Request $request)
    {
        $attendance = Attendance::where('user_id', $request->user()->id)
            ->where('work_date', now()->toDateString())
            ->firstOrFail();

        if ($attendance->status !== 'working') {
            return back();
        }

        $attendance->breaks()->create(['started_at' => now()]);
        $attendance->update(['status' => 'on_break']);

        return back();
    }

    public function breakEnd(Request $request)
    {
        $attendance = Attendance::where('user_id', $request->user()->id)
            ->where('work_date', now()->toDateString())
            ->firstOrFail();

        $latestBreak = $attendance->breaks()->whereNull('ended_at')->latest('started_at')->first();
        if (! $latestBreak) {
            return back();
        }

        $latestBreak->update(['ended_at' => now()]);
        $attendance->update(['status' => 'working']);

        return back();
    }

    public function clockOut(Request $request)
    {
        $attendance = Attendance::where('user_id', $request->user()->id)
            ->where('work_date', now()->toDateString())
            ->firstOrFail();

        if ($attendance->status !== 'working') {
            return back();
        }

        $attendance->update([
            'clock_out_at' => now(),
            'status' => 'done',
        ]);

        return back()->with('message', 'お疲れ様でした。');
    }
}
