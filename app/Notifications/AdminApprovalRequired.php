<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class AdminApprovalRequired extends Notification
{
    use Queueable;

    public $user;
    public $approvalToken;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, string $approvalToken)
    {
        $this->user = $user;
        $this->approvalToken = $approvalToken;
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
        // Add admin_email to the approval URL
        $approvalUrl = url('/admin/approve-user') . '?token=' . $this->approvalToken . '&user=' . $this->user->id . '&admin_email=' . urlencode($notifiable->email);

        return (new MailMessage)
            ->subject('New Staff Registration - Approval Required')
            ->greeting('Hello Admin,')
            ->line('A new staff member has registered and requires your approval.')
            ->line('**User Details:**')
            ->line('Name: ' . $this->user->name)
            ->line('Email: ' . $this->user->email)
            ->line('Phone: ' . ($this->user->phone_number ?? 'Not provided'))
            ->line('Registration Date: ' . $this->user->created_at->format('F j, Y \a\t g:i A'))
            ->line('The user will need to verify their email address first, then you can approve them for system access.')
            ->action('Approve User', $approvalUrl)
            ->line('Once both email verification and admin approval are complete, the user will be able to access the system.')
            ->line('If you did not expect this registration, please contact the system administrator.')
            ->salutation('Best regards, ' . config('app.name') . ' System');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'approval_token' => $this->approvalToken,
        ];
    }
}
