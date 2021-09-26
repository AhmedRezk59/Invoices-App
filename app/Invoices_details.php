<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoices_details extends Model
{
    protected $guarded = [];

    public function status()
    {
        return $this->belongsTo('App\Status', 'value_status');
    }
}
