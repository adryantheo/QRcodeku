<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $fillable = [
        'name',
    ];

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }
}
