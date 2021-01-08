<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class ReceivingListDetails extends Model
{
    protected $table = 'inv_receiving_details';
    protected $primaryKey = 'receiving_details_id';
    public $timestamps = false;
}
