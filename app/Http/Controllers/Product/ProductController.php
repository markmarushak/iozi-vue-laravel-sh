<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\AttributeUser;
use App\Models\Attribute;
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
    	$attachment = new Image;
        $attachment->name = $request->name;
        $attachment->product_id = 2;
        $attachment->path = $attachment->upload($request->attachment);

        $attachment->save();

        return response()->json([
            'message' => 'Attachment has been successfully uploaded.',
        ]);
    }

    public function destroy(Request $request)
    {
    	return Product::find($request->id)->remove();
    }
}
