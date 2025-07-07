<?php

namespace App\Notifications;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupplierCreated extends Notification
{
    use Queueable;

    public $supplier;
    public $staff;

    /**
     * Create a new notification instance.
     */
    public function __construct(Supplier $supplier, User $staff)
    {
        $this->supplier = $supplier;
        $this->staff = $staff;
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
        return (new MailMessage)
            ->subject('New Supplier Created')
            ->greeting('Hello Admin,')
            ->line('A new supplier has been created by ' . $this->staff->name . '.')
            ->line('**Supplier Details:**')
            ->line('Name: ' . $this->supplier->supplier_name)
            ->line('Phone: ' . $this->supplier->phone_number)
            ->action('View Supplier', url('/supplier'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
