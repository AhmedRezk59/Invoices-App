<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function section(){
        return $this->belongsTo('App\Section');
    }

    public function status()
    {
        return $this->belongsTo('App\Status' , 'value_status');
    }
}
