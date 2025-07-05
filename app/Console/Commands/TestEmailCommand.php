<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\AdminApprovalRequired;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing email functionality...');

        // Create a test user
        $testUser = new User([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'id' => 999
        ]);
        $testUser->created_at = now(); // Set created_at for test

        // Create a test admin
        $testAdmin = new User([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'id' => 1
        ]);

        $approvalToken = Str::random(64);

        try {
            // Send test notification
            $testAdmin->notify(new AdminApprovalRequired($testUser, $approvalToken));

            $this->info('✅ Email sent successfully!');
            $this->info('📧 Check your storage/logs/laravel.log file to see the email content.');

        } catch (\Exception $e) {
            $this->error('❌ Email failed: ' . $e->getMessage());
        }
    }
}
