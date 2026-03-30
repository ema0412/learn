<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceUpdateRequest;
use App\Models\Attendance;
use App\Models\AttendanceCorrectionRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceListController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));
        $target = Carbon::createFromFormat('Y-m', $month);

        $attendances = Attendance::where('user_id', $request->user()->id)
            ->whereBetween('work_date', [$target->copy()->startOfMonth(), $target->copy()->endOfMonth()])
            ->with('breaks')
            ->orderBy('work_date')
            ->get();

        return view('attendance.list', compact('attendances', 'month'));
    }

    public function show(Attendance $attendance)
    {
        $this->authorizeOwner($attendance);

        $pendingRequest = $attendance->correctionRequests()->where('status', 'pending')->latest()->first();

        return view('attendance.detail', [
            'attendance' => $attendance->load('breaks', 'user'),
            'pendingRequest' => $pendingRequest,
        ]);
    }

    public function update(AttendanceUpdateRequest $request, Attendance $attendance)
    {
        $this->authorizeOwner($attendance);

        AttendanceCorrectionRequest::create([
            'attendance_id' => $attendance->id,
            'user_id' => $request->user()->id,
            'status' => 'pending',
            'requested_clock_in_at' => $request->clock_in_at,
            'requested_clock_out_at' => $request->clock_out_at,
            'requested_breaks' => $request->input('breaks', []),
            'note' => $request->note,
        ]);

        return back()->with('message', '修正申請を送信しました。');
    }

    private function authorizeOwner(Attendance $attendance)
    {
        if (auth()->id() !== $attendance->user_id && ! auth()->user()->is_admin) {
            abort(403);
        }
    }
}
