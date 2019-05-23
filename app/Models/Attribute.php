<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uploadable;

class Attribute extends Model
{
    use Uploadable;

    const TYPE_LIST = 'list';
    const TYPE_TEXT = 'input';


    protected $attributes = [
        'parent_id' => 0,
    ];

    public $appends = ['change', 'value', 'parent_id'];

    protected $fillable = ['name', 'format', 'types'];

    public $timestamps = false;



    public function getChangeAttribute()
    {
        return $this->change = false;
    }

    public function getValueAttribute()
    {
        return $this->value = '';
    }

    public function getParentIdAttribute()
    {
        return $this->parent_id = 0;
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    public function duplicate($data)
    {
        return $this->where('name','LIKE',$data->name)
            ->where('types', $data->type)
            ->first();
    }

    public function parent($id)
    {
        return $this->where('parent_id',$id)->get();
    }

    public function option()
    {
        return $this->hasMany('App\Models\Attribute', 'id', 'parent_id');
    }

}
