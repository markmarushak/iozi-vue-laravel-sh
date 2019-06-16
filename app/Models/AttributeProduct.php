<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttributeProduct extends Model
{

    protected $table = 'attribute_product';

    protected $fillable = ['attribute_id','product_id','value'];

    protected $appends = [
        'old'
    ];

    public $timestamps = false;

    public function attribute()
    {
        return $this->hasMany('App\Models\Attribute', 'id', 'attribute_id');
    }

    public function types($id)
    {
        return DB::table('attributes')->where('id', $id)->select('types')->first();
    }

    public function isHas($data, $product_id)
    {
        return $this->where('product_id', $product_id)
            ->where('attribute_id', $data['id'])
            ->first();
    }

    public function getOldAttribute()
    {
        return $this->old = $this->value;
    }

}
