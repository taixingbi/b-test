<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use Log;
use App\PosRentsOrder;
use Auth;
use App\User;
use PDF;
class VoucherRentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $email;
    private $agent_rents_order;
    private $hide;
    private $agent_email;

    public function __construct($agent_email, $email, PosRentsOrder $agent_rents_order, $hide)
    {
        $this->agent_email = $agent_email;
        $this->email = $email;
        $this->agent_rents_order = $agent_rents_order;
        $this->hide = $hide;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $location = DB::table("locations")->where("title",$this->agent_rents_order->location)->first();
        $user = User::where("email",$this->agent_email)->first();
//        $purchase_date = $agent_rents_order->created_at;
        explode(" ",$this->agent_rents_order->created_at)[0];
        $date=date_create(explode(" ",$this->agent_rents_order->created_at)[0]);
        $date = $date->format('Y-m-d');
        $new_date = date('F dS Y', strtotime($date));


        $data= [
            'name' => 'Bigbike',
            'msg' => 'Order Confirmation',
            'payment_type'=>$this->agent_rents_order->payment_type,
            'agent'=>$this->agent_rents_order->tix_agent,
            'customer_email'=>$this->agent_rents_order->customer_email,
            'completed_at'=>$this->agent_rents_order->completed_at,
            'total_price_after_tax'=>$this->agent_rents_order->total_price_after_tax,
            'agent_price_after_tax'=>$this->agent_rents_order->agent_price_after_tax,
            'barcode'=>$this->agent_rents_order->barcode,
            'customer_name'=>$this->agent_rents_order->customer_name." ".$this->agent_rents_order->customer_lastname,
            'customer_email'=>$this->agent_rents_order->customer_email,
            'location'=>$this->agent_rents_order->location." New York, NY ".$location->zipcode,
            'date'=>$this->agent_rents_order->date,
            'time'=>$this->agent_rents_order->time,
            'duration'=>$this->agent_rents_order->duration,
            'adult'=>$this->agent_rents_order->adult,
            'child'=>$this->agent_rents_order->child,
            'tandem'=>$this->agent_rents_order->tandem,
            'road'=>$this->agent_rents_order->road,
            'mountain'=>$this->agent_rents_order->mountain,
            'trailer'=>$this->agent_rents_order->trailer,
            'seat'=>$this->agent_rents_order->seat,
            'basket'=>$this->agent_rents_order->basket,
            'dropoff'=>$this->agent_rents_order->dropoff,
            'completed_at'=>$new_date,
            'phone'=>$location->phone,
            "barcode"=>$this->agent_rents_order->barcode.'.png',
            'agent_phone'=>$user->phone,
            'hide'=>$this->hide,
            'insurance'=>$this->agent_rents_order->insurance,
        ];
        $pdf = PDF::loadView('emails.rent-voucher',$data);
        $path = public_path("images/pdf/RentVoucher.pdf");
        $pdf->save($path);

        Log::info("hide: ".$this->hide);
//        $path = public_path("images/pdf/test.pdf");
        return $this->view('emails.rent-email')
            ->attach($path)
            ->with([
                'name' => 'Bigbike',
                'msg' => 'Order Confirmation',
                'payment_type'=>$this->agent_rents_order->payment_type,
                'agent'=>$this->agent_rents_order->tix_agent,
                'customer_email'=>$this->agent_rents_order->customer_email,
                'completed_at'=>$this->agent_rents_order->completed_at,
                'total_price_after_tax'=>$this->agent_rents_order->total_price_after_tax,
                'agent_price_after_tax'=>$this->agent_rents_order->agent_price_after_tax,
                'barcode'=>$this->agent_rents_order->barcode,
                'customer_name'=>$this->agent_rents_order->customer_name." ".$this->agent_rents_order->customer_lastname,
                'customer_email'=>$this->agent_rents_order->customer_email,
                'location'=>$this->agent_rents_order->location." New York, NY ".$location->zipcode,
                'date'=>$this->agent_rents_order->date,
                'time'=>$this->agent_rents_order->time,
                'duration'=>$this->agent_rents_order->duration,
                'adult'=>$this->agent_rents_order->adult,
                'child'=>$this->agent_rents_order->child,
                'tandem'=>$this->agent_rents_order->tandem,
                'road'=>$this->agent_rents_order->road,
                'mountain'=>$this->agent_rents_order->mountain,
                'trailer'=>$this->agent_rents_order->trailer,
                'seat'=>$this->agent_rents_order->seat,
                'basket'=>$this->agent_rents_order->basket,
                'dropoff'=>$this->agent_rents_order->dropoff,
                'completed_at'=>$new_date,
                'phone'=>$location->phone,
                "barcode"=>$this->agent_rents_order->barcode.'.png',
                'agent_phone'=>$user->phone,
                'hide'=>$this->hide,
                'insurance'=>$this->agent_rents_order->insurance,
            ]);

//        return $this
////            ->view('emails.rent-order-email');
//        ->view('emails.test');



//        ->view('emails.orders.shipped');
    }
}
