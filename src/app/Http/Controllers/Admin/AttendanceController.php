<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceUpdateRequest;
use App\Models\Attendance;
use App\Models\BreakTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function daily(Request $request)
    {
        $date = $request->query('date', now()->toDateString());
        $attendances = Attendance::with('user', 'breaks')->whereDate('work_date', $date)->get();

        return view('admin.attendance-list', compact('attendances', 'date'));
    }

    public function detail(Attendance $attendance)
    {
        return view('admin.attendance-detail', ['attendance' => $attendance->load('user', 'breaks')]);
    }

    public function update(AttendanceUpdateRequest $request, Attendance $attendance)
    {
        $attendance->update([
            'clock_in_at' => $request->clock_in_at,
            'clock_out_at' => $request->clock_out_at,
            'note' => $request->note,
        ]);

        $attendance->breaks()->delete();
        foreach ($request->input('breaks', []) as $break) {
            if (! empty($break['started_at'])) {
                BreakTime::create([
                    'attendance_id' => $attendance->id,
                    'started_at' => $break['started_at'],
                    'ended_at' => $break['ended_at'] ?? null,
                ]);
            }
        }

        return back()->with('message', '勤怠情報を修正しました。');
    }

    public function staffList()
    {
        $users = User::where('is_admin', false)->get();
        return view('admin.staff-list', compact('users'));
    }

    public function staffMonthly(Request $request, User $user)
    {
        $month = $request->query('month', now()->format('Y-m'));
        $target = Carbon::createFromFormat('Y-m', $month);

        $attendances = Attendance::where('user_id', $user->id)
            ->whereBetween('work_date', [$target->copy()->startOfMonth(), $target->copy()->endOfMonth()])
            ->with('breaks')
            ->orderBy('work_date')
            ->get();

        return view('admin.staff-monthly', compact('user', 'attendances', 'month'));
    }
}
