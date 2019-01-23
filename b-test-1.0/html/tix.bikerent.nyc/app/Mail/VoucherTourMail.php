<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use Log;
use App\PosToursOrder;
use Auth;
use App\User;
use PDF;
class VoucherTourMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $email;
    private $agent_tours_order;
    private $hide;
    private $agent_email;

    public function __construct($agent_email, $email, PosToursOrder $agent_tours_order, $hide)
    {
        $this->agent_email = $agent_email;
        $this->email = $email;
        $this->agent_tours_order = $agent_tours_order;
        $this->hide = $hide;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $location = DB::table("locations")->where("title",$this->agent_tours_order->location)->first();
//        $purchase_date = $agent_rents_order->created_at;
        $user = User::where("email",$this->agent_email)->first();
        explode(" ",$this->agent_tours_order->created_at)[0];
        $date=date_create(explode(" ",$this->agent_tours_order->created_at)[0]);
        $date = $date->format('Y-m-d');

        $new_date = date('F dS Y', strtotime($date));

        $data = [
            'name' => 'Bigbike',
            'msg' => 'Order Confirmation',
            'payment_type'=>$this->agent_tours_order->payment_type,
            'completed_at'=>$new_date,
            'agent'=>$this->agent_tours_order->tix_agent,
//            'agent_email'=>$agent_tours_order->tix_agent,
            'location'=>$this->agent_tours_order->location." New York, NY ".$location->zipcode,
            'tour_type'=>mb_strtoupper($this->agent_tours_order->tour_type),
            'tour_place'=>strtoupper($this->agent_tours_order->tour_place),
            'customer_name'=>$this->agent_tours_order->customer_name." ".$this->agent_tours_order->customer_lastname,
            'total_price_after_tax'=>$this->agent_tours_order->total_price_after_tax,
            'agent_price_after_tax'=>$this->agent_tours_order->agent_price_after_tax,
            'barcode'=>$this->agent_tours_order->barcode,
            'customer_email'=>$this->agent_tours_order->customer_email,
            'date'=>$this->agent_tours_order->date,
            'time'=>$this->agent_tours_order->time,'tour_type'=>$this->agent_tours_order->tour_type,
            'adult'=>$this->agent_tours_order->adult,
            'child'=>$this->agent_tours_order->child,
            'hide'=>$this->hide,
            "barcode"=>$this->agent_tours_order->barcode.'.png',
            'agent_phone'=>$user->phone,
            'phone'=>$location->phone,
            'total_people'=>$this->agent_tours_order->total_people
        ];
        $pdf = PDF::loadView('emails.tour-voucher',$data);
        $path = public_path("images/pdf/TourVoucher.pdf");
        $pdf->save($path);

        Log::info("here3");
        return $this->view('emails.tour-email')
            ->attach($path)
            ->with([
                'name' => 'Bigbike',
                'msg' => 'Order Confirmation',
                'payment_type'=>$this->agent_tours_order->payment_type,
                'completed_at'=>$new_date,
                'agent'=>$this->agent_tours_order->tix_agent,
//            'agent_email'=>$agent_tours_order->tix_agent,
                'location'=>$this->agent_tours_order->location." New York, NY ".$location->zipcode,
                'tour_type'=>mb_strtoupper($this->agent_tours_order->tour_type),
                'tour_place'=>strtoupper($this->agent_tours_order->tour_place),
                'customer_name'=>$this->agent_tours_order->customer_name." ".$this->agent_tours_order->customer_lastname,
                'total_price_after_tax'=>$this->agent_tours_order->total_price_after_tax,
                'agent_price_after_tax'=>$this->agent_tours_order->agent_price_after_tax,
                'barcode'=>$this->agent_tours_order->barcode,
                'customer_email'=>$this->agent_tours_order->customer_email,
                'date'=>$this->agent_tours_order->date,
                'time'=>$this->agent_tours_order->time,'tour_type'=>$this->agent_tours_order->tour_type,
                'adult'=>$this->agent_tours_order->adult,
                'child'=>$this->agent_tours_order->child,
                'hide'=>$this->hide,
                "barcode"=>$this->agent_tours_order->barcode.'.png',
                'agent_phone'=>$user->phone,
                'phone'=>$location->phone,
                'total_people'=>$this->agent_tours_order->total_people
            ]);

//        return $this
////            ->view('emails.rent-order-email');
//        ->view('emails.test');



//        ->view('emails.orders.shipped');
    }
}
