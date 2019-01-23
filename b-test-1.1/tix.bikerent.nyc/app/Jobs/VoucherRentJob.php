<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\PosRentsOrder;
use DB;
use Auth;
use Mail;
use Log;
use App\Mail\VoucherRentMail;

class VoucherRentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $email;
    private $agent_rents_order;
    private $hide;
    private $agent_email;
    private $bcc;

    public function __construct($agent_email, $email, PosRentsOrder $agent_rents_order, $hide,$bcc)
    {
        $this->agent_email = $agent_email;
        $this->email = $email;
        $this->agent_rents_order = $agent_rents_order;
        $this->hide = $hide;
        $this->bcc = $bcc;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->bcc) {
            Mail::to($this->email)->bcc("reservations@bikerent.nyc")->send(new VoucherRentMail($this->agent_email, $this->email, $this->agent_rents_order, $this->hide));
        }else{
            Mail::to($this->email)->send(new VoucherRentMail($this->agent_email, $this->email, $this->agent_rents_order, $this->hide));
        }

//        Log::info("run email: ".$this->hide." end");

    }
}
