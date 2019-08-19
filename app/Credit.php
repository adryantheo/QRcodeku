<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credit extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'amount',
        'qr_strings',
        'brands_id'

    ];

    public function brands()
    {
        return $this->belongsTo(Brands::class);
    }
}
