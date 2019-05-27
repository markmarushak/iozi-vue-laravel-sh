<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use App\Models\AttributeProduct;
use App\Models\Attribute;
use App\Traits\Uploadable;
use League\Flysystem\Exception;

class ProductController extends Controller
{
    use Uploadable;

    public $ap;
    function __construct(AttributeProduct $ap)
    {
        $this->ap = $ap;
    }

    public function index(Request $request)
    {
        if($request->id){
            $products = Products::where('user_id', $request->id)->get();
        }else{
            $products = Products::all();
        }
        foreach ($products as &$product){
            $types = ['attr','option','images','time'];
            for($i = 0; $i< count($types); $i++){
                $product[$types[$i]] = DB::table('attribute_product')
                    ->where('attribute_product.product_id', $product->id)
                    ->where('attributes.types','LIKE', $types[$i])
                    ->leftJoin('attributes', 'attribute_product.attribute_id', 'attributes.id')
                    ->select('attribute_product.*','attributes.types', 'attributes.name','attributes.format')
                    ->get();
            }

            $product['storage'] = storage_path('public');
        }

        return $products;
    }

    public function show(Request $request)
    {
    	return Products::all($request->id);
    }

    public function store(Request $request)
    {
        $user_id = \Auth::user()->id;
        $data = $request->all();

        // создаем продукт
        $product = Products::create([
            'user_id'     => $user_id,
            'fullname'    => $data['fullname'],
            'description' => $data['description']
        ]);

        // перебераем атрибуты и сохраняем к данному продукту
        //  делаем проверку, создался ли продукт
        if($product->id)
        {
            // перебераем заголовки
            // attr, images, option, time
            foreach ($data['additional'] as $attr => $item)
            {
                foreach ($item as $val) {

                    if(!empty($val['value'])){
                        try{
                            AttributeProduct::create([
                                'attribute_id' => $val['id'],
                                'product_id'   => $product->id,
                                'value'        => $val['value']
                            ]);
                        }catch (\Exception $e){
                            dd($val['value']);
                            AttributeProduct::where('product_id', $product->id)->delete();
                            Products::where('id', $product->id)->delete();
                            return $e->getMessage();
                        }
                    }else{
                        AttributeProduct::where('product_id', $product->id)
                            ->where('attribute_id',$val['id'])
                            ->delete();
                    }
                }
            }
        }

        return response()->json([
            'message' => 'Attachment has been successfully uploaded.',
            'product' => $product
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        Products::where('id', $request->id)->update([
            'fullname'    => $data['fullname'],
            'description' => $data['description']
        ]);

        // перебераем атрибуты и сохраняем к данному продукту
        //  делаем проверку, создался ли продукт
        // перебераем заголовки
        // attr, images, option, time
        foreach ($data['additional'] as $attr => $item)
        {
            foreach ($item as $val) {

                if(empty($val['value'])){
                    $val['value'] = false;
                }

                if($this->ap->isHas($val, $request->id)){
                    AttributeProduct::where('product_id', $request->id)
                        ->where('attribute_id', $val['id'])
                        ->update([
                        'value' => $val['value']
                    ]);
                }else{
                    AttributeProduct::create([
                        'attribute_id' => $val['id'],
                        'product_id'   => $request->id,
                        'value'        => $val['value']
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'product has been successfully update.',
        ]);
    }

    public function destroy(Request $request)
    {
    	AttributeProduct::where('product_id', $request->id)->delete();

    	Products::where('id', $request->id)->delete();
    	return response()->json([
    	    'message' => 'product and all attribute delete'
        ]);
    }

    public function saveImage(Request $request)
    {
        if($request->img != null){
            $img = $this->upload($request->img);

            try{
                $image = AttributeProduct::create([
                    'attribute_id' => $request->attr_id,
                    'product_id'   => $request->product_id,
                    'value'        => $img
                ]);
            }catch (\Exception $e){
                AttributeProduct::where('product_id', $request->product_id)->delete();
                Products::where('id', $request->product_id)->delete();
                return $e->getMessage();
            }

            return response()->json([
                'message' => 'Image has been successfully saved.',
                'image-product' => $image
            ]);
        }

        return response()->json([
            'message' => 'Image not found.',
        ]);
    }

    public function uploadImage(Request $request)
    {
        if($request->img != null){
            $img = $this->upload($request->img);

            try{
                $image = AttributeProduct::where('product_id', $request->id)
                    ->where('attribute_id',$request->attr_id)
                    ->update([
                    'value'        => $img
                ]);
            }catch (\Exception $e){
                return $e->getMessage();
            }

            return response()->json([
                'message' => 'Image has been successfully saved.',
                'image-product' => $image
            ]);
        }

        return response()->json([
            'message' => 'Image not found.',
        ]);
    }

    public function search(Request $request)
    {
        $c = count($request->all());
        if($c <= 0){
            $products = Products::all();
        }else{
            $query =  Products::select('products.id')
                ->leftJoin('attribute_product','products.id', 'attribute_product.product_id')
                ->whereIn('attribute_product.attribute_id', $request->all())
                ->groupBy('attribute_product.id')
                ->havingRaw("count(*) = $c")
                ->get()->toArray();
//          dd($query);
            $products = Products::whereIn('id', $query)->get();
        }


            foreach ($products as &$product){
                $types = ['attr','option','images','time'];
                for($i = 0; $i< count($types); $i++){
                    $product[$types[$i]] = DB::table('attribute_product')
                        ->where('attribute_product.product_id', $product->id)
                        ->where('attributes.types','LIKE', $types[$i])
                        ->leftJoin('attributes', 'attribute_product.attribute_id', 'attributes.id')
                        ->select('attribute_product.*','attributes.types', 'attributes.name','attributes.format')
                        ->get();
                }

                $product['storage'] = storage_path('public');
            }

            return $products;


    }

}
