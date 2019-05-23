<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uploadable;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    use Uploadable;

    public $product_table = 'attribute_product';

    protected $fillable = ['user_id', 'fullname', 'description'];

    public function attribute()
    {
        return $this->hasMany('App\Models\AttributeProduct', 'product_id');
    }

    public function images()
    {
        return $this->hasMany('App\Models\AttributeProduct', 'product_id');
    }

    public function options()
    {
        return $this->hasMany('App\Models\AttributeProduct', 'product_id');
    }

    public function times()
    {
        return $this->hasMany('App\Models\AttributeProduct', 'product_id');
    }

}
