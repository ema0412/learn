<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'clock_in_at' => ['nullable', 'date'],
            'clock_out_at' => ['nullable', 'date'],
            'note' => ['required', 'string'],
            'breaks' => ['nullable', 'array'],
            'breaks.*.started_at' => ['nullable', 'date'],
            'breaks.*.ended_at' => ['nullable', 'date'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $clockIn = $this->input('clock_in_at');
            $clockOut = $this->input('clock_out_at');

            if ($clockIn && $clockOut && strtotime($clockIn) >= strtotime($clockOut)) {
                $validator->errors()->add('clock_in_at', '出勤時間もしくは退勤時間が不適切な値です');
            }

            foreach (($this->input('breaks') ?? []) as $break) {
                if (empty($break['started_at'])) {
                    continue;
                }

                if ($clockIn && strtotime($break['started_at']) < strtotime($clockIn)) {
                    $validator->errors()->add('breaks', '休憩時間が不適切な値です');
                }

                if ($clockOut && strtotime($break['started_at']) > strtotime($clockOut)) {
                    $validator->errors()->add('breaks', '休憩時間が不適切な値です');
                }

                if (!empty($break['ended_at']) && $clockOut && strtotime($break['ended_at']) > strtotime($clockOut)) {
                    $validator->errors()->add('breaks', '休憩時間もしくは退勤時間が不適切な値です');
                }
            }
        });
    }

    public function messages()
    {
        return [
            'note.required' => '備考を記入してください',
        ];
    }
}
