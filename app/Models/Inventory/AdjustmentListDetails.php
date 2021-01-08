<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class AdjustmentListDetails extends Model
{
    protected $table = 'inv_adjustment_details';
    protected $primaryKey = 'adjustments_details_id';
    public $timestamps = false;
}
