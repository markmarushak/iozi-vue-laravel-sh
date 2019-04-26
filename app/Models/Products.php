<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public function profile()
    {
    	return $this->hasOne(App\Models\Profile::class);
    }
}
