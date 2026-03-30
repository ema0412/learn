<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_clock_in_once_per_day()
    {
        $user = User::factory()->create();
        $user->forceFill(['email_verified_at' => now()])->save();
        $this->actingAs($user);

        $this->post(route('attendance.clock-in'))->assertStatus(302);
        $this->post(route('attendance.clock-in'))->assertStatus(302);

        $attendance = Attendance::where('user_id', $user->id)->where('work_date', now()->toDateString())->first();
        $this->assertEquals('working', $attendance->status);
    }
}
