<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\AttributeUser;
use App\Models\OptionUser;
use App\Models\Image;

class ProductController extends Controller
{
    public function index()
    {
    	return Product::all();
    }

    public function show(Request $request)
    {
    	return Product::all($request->id);
    }

    public function store(Request $request)
    {   
        $user = \Auth::user()->id;
        
        if($request->attribute)
        {
            foreach ($request->attribute as $atr) {
                $attr = new AttributeUser;
                $attr->attribute_id = $atr->id;
                $attr->user_id = $user
                $attr->value = $atr->value;
                $attr->save();
            }
        }

        if($request->options)
        {
            foreach ($request->options as $option_k) {
                $option = new OptionUser;
                $option->attribute_id = $option_k->id;
                $option->user_id = $user
                $option->value = $option_k->value;
                $option->save();
            }
        }

        if($request->times)
        {
            foreach ($request->times as $key) {
                $time = new OptionUser;
                $time->product_id = $product_id;
                $time->one = $key->one;
                $time->two = $key->two;
                $time->night = $key->night;
                $time->save();
            }
        }

        if($request->images)
        {
            $attachment = new Image;
            $attachment->name = $request->name;
            $attachment->product_id = 2;
            $attachment->path = $attachment->upload($request->attachment);

            $attachment->save();
            
        }
    	return 0;
    }

    public function destroy(Request $request)
    {
    	return Product::find($request->id)->remove();
    }
}
