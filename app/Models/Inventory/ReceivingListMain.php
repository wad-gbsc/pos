<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class ReceivingListMain extends Model
{
    protected $table = 'inv_receiving_main';
    protected $primaryKey = 'receiving_id';
    public $timestamps = false;
}
