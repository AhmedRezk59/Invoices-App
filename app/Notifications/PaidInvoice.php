<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaidInvoice extends Notification
{
    use Queueable;

    private $invoice_id;
    private $section;
    private $product;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice_id, $section, $product)
    {
        $this->invoice_id = $invoice_id;
        $this->section = $section;
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {


        $url = 'http://127.0.0.1:8000/invoicedetails/' . $this->invoice_id;

        return (new MailMessage)
            ->subject('إضافة فاتورة جديدة')
            ->line('القسم :' . $this->section)
            ->line('المنتج :' . $this->product)
            ->action('عرض الفاتورة', $url)
            ->line('شكرا لإستخدامك صفحتنا لإدارة الفواتير');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
