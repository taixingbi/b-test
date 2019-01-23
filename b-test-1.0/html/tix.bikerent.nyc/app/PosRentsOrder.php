<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosRentsOrder extends Model
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
        "completed_at",
        "date",
        "time",
        "duration",
        "end_time",
        "customer_name",
        "customer_lastname",
        "customer_cc_name",
        "customer_cc_lastname",
        "customer_email",
        "customer_address_phone",
        "customer_country",
        "coupon",
        "group",
        "customer_type",
        "agent_name",
        "agent_level",
        "agent_paid",
        "adjust_price",
        "adjust_percentage",
        "adult",
        "child",
        "tandem",
        "road",
        "mountain",
        "total_bikes",
        "trailer",
        "basket",
        "seat",
        "locks",
        "dropoff",
        "insurance",
        "deposit",
        "deposit_pay_type",
        "comment",
        "barcode",
        "promo_code",
        "served",
        "served_date",
        "refund_transaction_id"
    ];

}
