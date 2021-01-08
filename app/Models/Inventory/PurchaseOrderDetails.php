<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetails extends Model
{
    protected $table = 'inv_purchase_order_details';
    protected $primaryKey = 'purchase_order_details_id';
    public $timestamps = false;
}
