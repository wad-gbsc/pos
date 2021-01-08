<?php

namespace App\Models\Pos;

use Illuminate\Database\Eloquent\Model;

class PosItems extends Model
{
    protected $table = 'pos_invoice_items';
    protected $primaryKey = 'invoice_item_id';
    public $timestamps = false;
}
