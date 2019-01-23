<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class SendMarketingEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $name;
    public $yelp_url;
    public $google_url;
    public $trip_url;
//    public $user;
    public $email_address;
    public $testing;
    public $gosomewhereafter_lunch;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$yelp_url,$google_url,$trip_url)
    {
        $this->name = $name;
        $this->yelp_url = $yelp_url;
        $this->google_url = $google_url;
        $this->trip_url = $trip_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        Log::info("build: ".$this->name);
        return $this->subject('Please review us')->view('emails.marketing')->with([
            'name' => $this->name,
            'trip_url' => $this->trip_url,
            'google_url' => $this->google_url,
            'yelp_url' => $this->yelp_url,
        ]);
    }
}
