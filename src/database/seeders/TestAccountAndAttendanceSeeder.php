<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\BreakTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestAccountAndAttendanceSeeder extends Seeder
{
    public function run()
    {
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => '管理者ユーザー',
                'password' => Hash::make('password123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $generalUser = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => '一般ユーザー',
                'password' => Hash::make('password123'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        $this->seedAttendanceRecords($adminUser, 2);
        $this->seedAttendanceRecords($generalUser, 5);
    }

    private function seedAttendanceRecords(User $user, int $days): void
    {
        for ($i = 1; $i <= $days; $i++) {
            $workDate = Carbon::today()->subDays($i);
            $clockInAt = $workDate->copy()->setTime(9, 0);
            $clockOutAt = $workDate->copy()->setTime(18, 0);

            $attendance = Attendance::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'work_date' => $workDate->toDateString(),
                ],
                [
                    'clock_in_at' => $clockInAt,
                    'clock_out_at' => $clockOutAt,
                    'status' => 'done',
                    'note' => 'テスト用の勤怠データ',
                ]
            );

            BreakTime::where('attendance_id', $attendance->id)->delete();

            BreakTime::create([
                'attendance_id' => $attendance->id,
                'started_at' => $workDate->copy()->setTime(12, 0),
                'ended_at' => $workDate->copy()->setTime(13, 0),
            ]);
        }
    }
}
