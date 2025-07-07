<?php

namespace App\Notifications;

use App\Models\Record;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecordUpdated extends Notification
{
    use Queueable;

    public $record;
    public $staff;
    public $originalData;

    /**
     * Create a new notification instance.
     */
    public function __construct(Record $record, User $staff, array $originalData)
    {
        $this->record = $record;
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
            ->subject('Record Information Updated')
            ->greeting('Hello Admin,')
            ->line('A record with record ID ' . $this->record->record_id . ' for supplier ' . $this->record->supplier->supplier_name . ' has been updated by ' . $this->staff->name . '.')
            ->line('**Changes:**');

        foreach ($this->originalData as $key => $value) {
            if ($this->record->{$key} != $value) {
                $mailMessage->line('**' . ucfirst(str_replace('_', ' ', $key)) . ':** ' . $value . ' -> ' . $this->record->{$key});
            }
        }

        $mailMessage->action('View Record', url('/records'))
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
