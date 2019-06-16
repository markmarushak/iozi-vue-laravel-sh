<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Confirm extends Model
{
    protected $table = 'confirm';

    protected $fillable = ['product_id', 'img'];

    public $timestamps = false;

    public function products()
    {
        return $this->hasOne('App\Models\Products','id', 'product_id');
    }
}
