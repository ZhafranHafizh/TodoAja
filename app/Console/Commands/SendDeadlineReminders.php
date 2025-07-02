<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Activity;
use App\Models\ActivityReminder;
use App\Mail\DeadlineReminder;
use Carbon\Carbon;

class SendDeadlineReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send-deadline-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for tasks approaching their deadlines (3 days and 30 minutes before)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for tasks with approaching deadlines...');

        $now = Carbon::now();
        $threeDaysFromNow = $now->copy()->addDays(3);
        $thirtyMinutesFromNow = $now->copy()->addMinutes(30);

        // Find activities with deadlines in 3 days (±1 hour for scheduling flexibility)
        $threeDayActivities = Activity::with(['user', 'category'])
            ->whereNotNull('deadline')
            ->where('status', '!=', 'completed')
            ->whereHas('user', function($query) {
                $query->whereNotNull('email');
            })
            ->whereBetween('deadline', [
                $threeDaysFromNow->copy()->subHour(),
                $threeDaysFromNow->copy()->addHour()
            ])
            ->whereDoesntHave('reminders', function($query) {
                $query->where('reminder_type', '3_days');
            })
            ->get();

        // Find activities with deadlines in 30 minutes (±5 minutes for scheduling flexibility)
        $thirtyMinuteActivities = Activity::with(['user', 'category'])
            ->whereNotNull('deadline')
            ->where('status', '!=', 'completed')
            ->whereHas('user', function($query) {
                $query->whereNotNull('email');
            })
            ->whereBetween('deadline', [
                $thirtyMinutesFromNow->copy()->subMinutes(5),
                $thirtyMinutesFromNow->copy()->addMinutes(5)
            ])
            ->whereDoesntHave('reminders', function($query) {
                $query->where('reminder_type', '30_minutes');
            })
            ->get();

        $totalSent = 0;

        // Send 3-day reminders
        foreach ($threeDayActivities as $activity) {
            try {
                Mail::to($activity->user->email)->send(new DeadlineReminder($activity, '3_days'));
                
                // Record that we sent this reminder
                ActivityReminder::create([
                    'activity_id' => $activity->id,
                    'reminder_type' => '3_days',
                    'sent_at' => $now,
                ]);

                $this->info("✓ Sent 3-day reminder for task: {$activity->title} to {$activity->user->email}");
                $totalSent++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to send 3-day reminder for task: {$activity->title} - " . $e->getMessage());
            }
        }

        // Send 30-minute reminders
        foreach ($thirtyMinuteActivities as $activity) {
            try {
                Mail::to($activity->user->email)->send(new DeadlineReminder($activity, '30_minutes'));
                
                // Record that we sent this reminder
                ActivityReminder::create([
                    'activity_id' => $activity->id,
                    'reminder_type' => '30_minutes',
                    'sent_at' => $now,
                ]);

                $this->info("🚨 Sent 30-minute urgent reminder for task: {$activity->title} to {$activity->user->email}");
                $totalSent++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to send 30-minute reminder for task: {$activity->title} - " . $e->getMessage());
            }
        }

        if ($totalSent === 0) {
            $this->info('No deadline reminders to send at this time.');
        } else {
            $this->info("Successfully sent {$totalSent} deadline reminder(s).");
        }

        return 0;
    }
}
