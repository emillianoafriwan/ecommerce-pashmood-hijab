<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // Variabel untuk menyimpan data pesanan

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan: Pembayaran Pesanan #' . $this->order->id . ' Ditolak',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment_rejected', // Kita akan buat file view-nya setelah ini
        );
    }
}