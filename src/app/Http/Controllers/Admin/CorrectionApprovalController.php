<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceCorrectionRequest;
use App\Models\BreakTime;

class CorrectionApprovalController extends Controller
{
    public function approve(AttendanceCorrectionRequest $attendance_correct_request)
    {
        $attendance = $attendance_correct_request->attendance;

        $attendance->update([
            'clock_in_at' => $attendance_correct_request->requested_clock_in_at,
            'clock_out_at' => $attendance_correct_request->requested_clock_out_at,
            'note' => $attendance_correct_request->note,
        ]);

        $attendance->breaks()->delete();
        foreach (($attendance_correct_request->requested_breaks ?? []) as $break) {
            if (! empty($break['started_at'])) {
                BreakTime::create([
                    'attendance_id' => $attendance->id,
                    'started_at' => $break['started_at'],
                    'ended_at' => $break['ended_at'] ?? null,
                ]);
            }
        }

        $attendance_correct_request->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('message', '承認しました。');
    }
}
