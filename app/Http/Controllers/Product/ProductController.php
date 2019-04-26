<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

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
    	return Product::create($request->all());
    }

    public function destroy(Request $request)
    {
    	return Product::delete($request->id);
    }
}
