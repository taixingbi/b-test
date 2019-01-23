<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosToursOrder extends Model
{
    protected $connection = 'mysql2';


    protected $fillable = [
        'sequantial',
        'location',
        'order_id',
        'cashier_email',
        'tix_agent',
        'order_completed',
        "payment_type",
        "reservation",
        "original_price",
        "total_price_before_tax",
        "total_price_after_tax",
        "agent_email",
        "agent_price_after_tax",
        "created_at",
        "refund_transaction_id",
        "tour_type",
        "tour_place",
        "date",
        "time",
        "real_time",
        "end_time",
        "customer_name",
        "customer_lastname",
        "customer_cc_name",
        "customer_cc_lastname",
        "customer_email",
        "customer_address_phone",
        "customer_country",
        "adult",
        "child",
        "pedicab",
        "walking",
        "total_people",
        "trailer",
        "seat",
        "basket",
        "insurance",
        "deposit",
        "deposit_pay_type",
        "comment",
        "barcode",
        "served",
        "served_date"


    ];
}
