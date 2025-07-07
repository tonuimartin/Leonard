<?php

namespace App\Notifications;

use App\Models\Record;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecordCreated extends Notification
{
    use Queueable;

    public $record;
    public $staff;

    /**
     * Create a new notification instance.
     */
    public function __construct(Record $record, User $staff)
    {
        $this->record = $record;
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
        $supplierName = $this->record->supplier->supplier_name ?? 'N/A';

        return (new MailMessage)
            ->subject('New Record Created')
            ->greeting('Hello Admin,')
            ->line('A new record has been created by ' . $this->staff->name . ' for supplier ' . $supplierName . '.')
            ->line('**Record Details:**')
            ->line('Lorry Amount: KSh ' . number_format((float) $this->record->lorry_amount, 2))
            ->line('Lorry Units: ' . $this->record->lorry_units . ' m³')
            ->line('Tractor Amount: KSh ' . number_format((float) $this->record->tractor_amount, 2))
            ->line('Tractor Units: ' . $this->record->tractor_units . ' m³')
            ->line('Total Expected Profit: KSh ' . number_format((float) $this->record->total_expected_profit, 2))
            ->line('Confirmed Cubic Meters: ' . $this->record->confirmed_cubic_meters . ' m³')
            ->line('Extra Cubic: ' . $this->record->extra_cubic . ' m³')
            ->line('Less Cubic: ' . $this->record->less_cubic . ' m³')
            ->action('View Records', url('/records'))
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
