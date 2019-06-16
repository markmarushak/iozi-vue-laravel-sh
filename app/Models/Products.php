<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uploadable;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    use Uploadable;

    public $product_table = 'attribute_product';

    protected $fillable = ['user_id', 'fullname', 'description', 'time_left'];

    protected $attributes = [
        'status' => 'off',
        'rating' => 0
    ];

    public function attributes()
    {
        return $this->hasMany('App\Models\AttributeProduct', 'product_id', 'id');
    }


}
