<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\PosToursOrder;
use DB;
use Auth;
use Mail;
use Log;
use App\Mail\VoucherTourMail;

class VoucherTourJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $email;
    private $agent_tours_order;
    private $hide;
    private $agent_email;
    private $bcc;

    public function __construct($agent_email, $email, PosToursOrder $agent_tours_order, $hide,$bcc)
    {
        $this->agent_email = $agent_email;
        $this->email = $email;
        $this->agent_tours_order = $agent_tours_order;
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
            Log::info("BCC");
            Mail::to($this->email)->bcc("reservations@bikerent.nyc")->send(new VoucherTourMail($this->agent_email, $this->email, $this->agent_tours_order, $this->hide));
        }else{
            Log::info("no bcc");
            Mail::to($this->email)->send(new VoucherTourMail($this->agent_email, $this->email, $this->agent_tours_order, $this->hide));
        }

    }
}
