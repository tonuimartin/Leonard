<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserApproved extends Notification
{
    use Queueable;

    public $approvedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $approvedBy)
    {
        $this->approvedBy = $approvedBy;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $loginUrl = url('/login');

        return (new MailMessage)
            ->subject('Account Approved - Welcome to ' . config('app.name'))
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Great news! Your account has been approved by our admin team.')
            ->line('**Account Details:**')
            ->line('Name: ' . $notifiable->name)
            ->line('Email: ' . $notifiable->email)
            ->line('Role: Staff Member')
            ->line('Approved by: ' . $this->approvedBy->name)
            ->line('Approval Date: ' . now()->format('F j, Y \a\t g:i A'))
            ->line('You can now log in to the system using your email and password.')
            ->action('Login to Dashboard', $loginUrl)
            ->line('If you have any questions or need assistance, please contact the admin team.')
            ->salutation('Welcome aboard! ' . config('app.name') . ' Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'approved_by' => $this->approvedBy->name,
            'approved_at' => now()->toISOString(),
        ];
    }
}
