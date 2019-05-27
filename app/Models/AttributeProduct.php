<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeProduct extends Model
{
    protected $table = 'attribute_product';

    protected $fillable = ['attribute_id','product_id','value'];

    public $timestamps = false;

    public function attribute()
    {
        return $this->hasOne('App\Models\Attribute', 'id', 'attribute_id');
    }

    public function types($id, $type)
    {
        return $this->where([
            'types','LIKE', $type,
            'product_id',$id
        ])->get();
    }

    public function isHas($data, $product_id)
    {
        return $this->where('product_id', $product_id)
            ->where('attribute_id', $data['id'])
            ->first();
    }

}
