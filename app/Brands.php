<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brands extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'image',
    ];

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }
}
