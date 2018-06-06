<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    protected $fields;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = $this->fields['name'] ?? '';

        return $this->from('no-reply@glissmedia.ru', 'Заявка с сайта ' . env('APP_NAME'))
            ->subject('Заказ тура | ' . $name)
            ->view('emails.order', ['fields' => $this->fields]);
    }
}
