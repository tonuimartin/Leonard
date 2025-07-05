<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\AdminApprovalRequired;
use Illuminate\Console\Command;

class DebugAdminEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:admin-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug admin email notifications';    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Debugging staff registration email flow...');
        
        // Check for admin users
        $admins = User::where('role_id', 1)->active()->get();
        $this->info("📊 Found {$admins->count()} admin users:");
        
        foreach ($admins as $admin) {
            $this->info("  - ID: {$admin->id}, Name: {$admin->name}, Email: {$admin->email}");
        }
        
        if ($admins->isEmpty()) {
            $this->error('❌ No admin users found! This is why approval emails are not being sent.');
            return;
        }
        
        // Simulate the exact staff registration process
        $this->info('🎭 Simulating staff registration process...');
        
        try {
            // Step 1: Create user (simulating the store method)
            $testUser = User::create([
                'name' => 'Debug Test Staff',
                'email' => 'debugtest' . time() . '@example.com',
                'phone_number' => '1234567890',
                'password' => bcrypt('password123'),
                'role_id' => 2, // Staff role
                'deleted' => 0,
                'admin_approved' => false,
            ]);
            
            $this->info("✅ Step 1: Created test user - ID: {$testUser->id}, Email: {$testUser->email}");
            
            // Step 2: Generate approval token (simulating generateAdminApprovalToken)
            $approvalToken = $testUser->generateAdminApprovalToken();
            $this->info("✅ Step 2: Generated approval token: " . substr($approvalToken, 0, 20) . "...");
            
            // Step 3: Send email verification (simulating sendEmailVerificationNotification)
            $testUser->sendEmailVerificationNotification();
            $this->info("✅ Step 3: Email verification sent");
            
            // Step 4: Send admin notifications (simulating notifyAdminsAboutNewRegistration)
            $this->info("📧 Step 4: Sending admin approval notifications...");
            
            foreach ($admins as $admin) {
                $this->info("  → Sending to: {$admin->email}");
                $admin->notify(new AdminApprovalRequired($testUser, $approvalToken));
                $this->info("  ✅ Sent successfully to {$admin->email}");
            }
            
            $this->info('🎉 Registration simulation completed successfully!');
            $this->info("� Check your Gmail inbox at: martinkirui57@gmail.com");
            $this->info("🗑️  Cleaning up: Deleting test user...");
            
            // Clean up the test user
            $testUser->forceDelete();
            $this->info("✅ Test user deleted");
            
        } catch (\Exception $e) {
            $this->error('❌ Error during registration simulation: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            
            // Clean up if user was created
            if (isset($testUser) && $testUser->exists) {
                $testUser->forceDelete();
                $this->info("🗑️  Cleaned up test user");
            }
        }
    }
}
