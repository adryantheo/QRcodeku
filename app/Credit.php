<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'amount',
        'qr_strings',
        'brands_id'

    ];

    public function brand()
    {
        return $this->belongsTo(Brands::class);
    }
}
