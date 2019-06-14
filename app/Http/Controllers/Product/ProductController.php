<?php

namespace App\Http\Controllers\Product;

use App\Libraries\Utils\Utils;
use App\Models\Confirm;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use App\Models\AttributeProduct;
use App\Models\Attribute;
use App\Traits\Uploadable;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;

class ProductController extends Controller
{
    use Uploadable;

    public $ap;
    function __construct(AttributeProduct $ap)
    {
        $this->ap = $ap;
    }

    public function index()
    {
        $products = Products::all();
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

    public function cabinet()
    {
        $user_id = Utils::getCurrentUserId();

        $products = Products::where('user_id', $user_id)->get();

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
        $product = Products::find($request->id);

            $types = ['attr','option','images','time'];
            for($i = 0; $i< count($types); $i++){
                $product[$types[$i]] = DB::table('attribute_product')
                    ->where('attribute_product.product_id', $product->id)
                    ->where('attributes.types','LIKE', $types[$i])
                    ->leftJoin('attributes', 'attribute_product.attribute_id', 'attributes.id')
                    ->select('attribute_product.*','attributes.types', 'attributes.name','attributes.format')
                    ->get();

            $product['storage'] = Storage::getFacadeApplication();
        }

        return $product;
    }

    public function store(Request $request)
    {
        $user_id = Utils::getCurrentUserId();
        $data = $request->all();

        // создаем продукт
        $product = Products::create([
            'user_id'     => $user_id,
            'fullname'    => $data['fullname'],
            'description' => $data['description'],
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
            
                if(!empty($val['value'])){

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
                }else {
                     AttributeProduct::where('product_id', $request->id)
                            ->where('attribute_id',$val['id'])
                            ->delete();
                }
            }
        }

        return response()->json([
            'message' => 'product has been successfully update.',
        ]);
    }

    public function destroy(Request $request)
    {

    	$attribute = AttributeProduct::where('product_id', $request->id)->with(['attribute'])->get();


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
                AttributeProduct::where('product_id', $request->id)
                    ->where('attribute_id', $request->attr_id)
                    ->updateOrCreate(['value' => $img],[
                    'attribute_id' => $request->attr_id,
                    'product_id'   => $request->id,
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

    public function confirm(Request $request)
    {
        if($request->id){
            $img = $this->upload($request->img);
            if($img){
                Confirm::where('product_id', $request->id)->updateOrCreate(['img' => $img], [
                    'product_id' => $request->id,
                    'img' => $img]);
                return response()->json([
                    'message' => 'Анкета отправлена на проверку'
                ]);
            }
            return response()->json([
                'message' => 'Фото не получено'
            ]);
        }
        return response()->json([
            'message' => 'ID продукта не передано'
        ]);
    }

    public function confirmList()
    {
        return Confirm::with(['product'])->get();
    }

    public function pay(Request $request)
    {
        return Products::where('product_id',$request->id)->updata(['time_left' => Date::now()]);
    }

}
