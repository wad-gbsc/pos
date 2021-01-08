<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Model;

class PosPayment extends Model
{
    protected $table = 'pos_invoice_payments';
    protected $primaryKey = 'payment_id';
    public $timestamps = false;
}
