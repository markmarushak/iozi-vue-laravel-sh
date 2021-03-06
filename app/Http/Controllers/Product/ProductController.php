<?php

namespace App\Http\Controllers\Product;

use App\Libraries\Utils\Utils;
use App\Models\Confirm;
use App\Models\User;
use Carbon\Carbon;
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

    public function index(Products $products)
    {
        $query = $products
                    ->where('time_left','>=', Carbon::now())
                    ->get();

        foreach ($query as &$product){

            foreach ($product->attributes as $attr)
            {
                $attr->type = $attr->types($attr->attribute_id)->types;
            }

        }
        return $query;
    }

    public function cabinet(Products $products)
    {
        $user = Utils::getCurrentUser();
        if($user->roleLevel != 1)
            $products->where('user_id', $user->id);

        $query = $products->get();
        foreach ($query as &$product){

            foreach ($product->attributes as $attr)
            {
                $attr->type = $attr->types($attr->attribute_id)->types;
            }

        }
        return $query;
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

        $isHas = Products::where('fullname','LIKE',$data['fullname'])->first();

        if(!$isHas){
            // создаем продукт
            $product = Products::create([
                'user_id'     => $user_id,
                'fullname'    => $data['fullname'],
                'description' => $data['description'],
                'phone' => $data['phone'],

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
    }

    public function update(Request $request)
    {
        $data = $request->all();

        Products::where('id', $request->id)->update([
            'fullname'    => $data['fullname'],
            'description' => $data['description'],
            'phone' => $data['phone'],
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

    public function destroy($id)
    {
        $product_id = $id;
    	$attrProduct = AttributeProduct::where('product_id', $product_id)->get();
    	foreach ($attrProduct as &$key){
    	    $type = $key->types($key['attribute_id']);
    	    if($type->types == 'images'){
    	        Storage::disk('public')->delete($key['value']);
                $key->delete();
            }
            $key->delete();
        }

    	Products::where('id', $product_id)->delete();
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

            if(isset($request->old)){
                Storage::disk('public')->delete($request->old);

                AttributeProduct::where('product_id', $request->id)
                    ->where('attribute_id', $request->attr_id)
                    ->update(['value' => $img]);

                return response()->json([
                    'message' => 'Image has been successfully saved.',
                    'old' => $request->old
                ]);
            }else{
                AttributeProduct::create([
                    'attribute_id' => $request->attr_id,
                    'product_id'   => $request->id,
                    'value'        => $img
                ]);
                return response()->json([
                    'message' => 'Create Images.',
                    'old' => $img
                ]);
            }



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
                $info = Confirm::where('product_id', $request->id)->updateOrCreate(['img' => $img], [
                    'product_id' => $request->id,
                    'img' => $img]);
                return response()->json([
                    'message' => 'Анкета отправлена на проверку',
                    'info'    => $info
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
        return Confirm::with(['products'])->get();
    }

    public function confirmSuccess(Request $request)
    {
        Products::where('id', $request->product_id)->update(['confirm' => 1]);
        Storage::disk('public')->delete($request->img);
        Confirm::find($request->id)->delete();

        return response()->json([
            'message' => 'Product Confirmed',
        ]);
    }

    public function pay(Request $request)
    {
        $user = User::find(Utils::getCurrentUserId());
        $user->money = $user->money - config('product.rent');
        $user->save();

        $data = Products::where('id',$request->id)->update([
            'time_left' => $request->time,
            'status'    => 'on'
        ]);
        return response()->json([
            'message' => 'Product payed',
            'data'    => $data,
            'user'    => $user
        ]);
    }

}
