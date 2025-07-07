<?php

namespace App\Notifications;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupplierUpdated extends Notification
{
    use Queueable;

    public $supplier;
    public $staff;
    public $originalData;

    /**
     * Create a new notification instance.
     */
    public function __construct(Supplier $supplier, User $staff, array $originalData)
    {
        $this->supplier = $supplier;
        $this->staff = $staff;
        $this->originalData = $originalData;
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
        $mailMessage = (new MailMessage)
            ->subject('Supplier Information Updated')
            ->greeting('Hello Admin,')
            ->line('Supplier ' . $this->supplier->name . ' has been updated by ' . $this->staff->name . '.')
            ->line('**Changes:**');

        foreach ($this->originalData as $key => $value) {
            if ($this->supplier->{$key} != $value) {
                $mailMessage->line('**' . ucfirst(str_replace('_', ' ', $key)) . ':** ' . $value . ' -> ' . $this->supplier->{$key});
            }
        }

        $mailMessage->action('View Supplier', url('/supplier'))
            ->line('Thank you for using our application!');

        return $mailMessage;
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
