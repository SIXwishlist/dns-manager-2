<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Domain;

class RequestChangeNSRecord extends Mailable
{
    use Queueable, SerializesModels;

    public $domain;
    public $ns1;
    public $ns2;
    public $note;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Domain $domain, $ns1, $ns2, $note)
    {
        $this->domain = $domain;
        $this->ns1 = $ns1;
        $this->ns2 = $ns2;
        $this->note = $note;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Yêu cầu thay đổi bản ghi NS mặc định')->view('emails.request_change_ns_record');
    }
}
