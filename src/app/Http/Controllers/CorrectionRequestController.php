<?php

namespace App\Http\Controllers;

use App\Models\AttendanceCorrectionRequest;
use Illuminate\Http\Request;

class CorrectionRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        $query = AttendanceCorrectionRequest::with('attendance.user');

        if (! $request->user()->is_admin) {
            $query->where('user_id', $request->user()->id);
        }

        $requests = $query->where('status', $status)->latest()->get();

        return view('requests.list', compact('requests', 'status'));
    }

    public function show(AttendanceCorrectionRequest $attendance_correct_request)
    {
        if (! auth()->user()->is_admin && auth()->id() !== $attendance_correct_request->user_id) {
            abort(403);
        }

        return view('requests.detail', ['requestData' => $attendance_correct_request->load('attendance.user')]);
    }
}
