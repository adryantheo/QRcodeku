<?php

namespace App\Mail;

use App\Credit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $credit;

    
    public function __construct(Credit $credit)
    {
        $this->credit = $credit;
    }

    
    public function build()
    {
        return $this->from('myQR@AT.com')->view('emailku');
            
    }
}
