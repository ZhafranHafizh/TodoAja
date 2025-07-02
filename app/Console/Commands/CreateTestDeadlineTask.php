<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;

class CreateTestDeadlineTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:create-deadline-task {--type=3days : Type of test (3days or 30minutes)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test task with deadline for testing reminder system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');
        $user = User::whereNotNull('email')->first();
        
        if (!$user) {
            $this->error('No user with email found for testing.');
            return 1;
        }

        if ($type === '30minutes') {
            $deadline = Carbon::now()->addMinutes(30);
            $title = 'Test 30-Minute Deadline Task';
        } else {
            $deadline = Carbon::now()->addDays(3);
            $title = 'Test 3-Day Deadline Task';
        }

        $activity = Activity::create([
            'title' => $title,
            'description' => 'This is a test task created to verify the deadline reminder system is working correctly. You should receive an email reminder for this task.',
            'status' => 'in_progress',
            'deadline' => $deadline,
            'user_id' => $user->id,
        ]);

        $this->info("Created test activity:");
        $this->info("- ID: {$activity->id}");
        $this->info("- Title: {$activity->title}");
        $this->info("- Deadline: {$deadline->format('Y-m-d H:i:s')}");
        $this->info("- User: {$user->email}");
        $this->info("- Type: {$type}");

        return 0;
    }
}
