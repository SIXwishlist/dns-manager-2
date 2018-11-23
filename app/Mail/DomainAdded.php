<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Domain;

class DomainAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $domain;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Domain $domain, $password)
    {
        $this->domain = $domain;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Tên miền mới đã được thêm')->view('emails.domain_added');
    }
}
