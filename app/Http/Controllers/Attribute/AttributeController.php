<?php

namespace App\Http\Controllers\Attribute;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attribute;

class AttributeController extends Controller
{
    public $attr;

    public function __construct(Attribute $attr)
    {
        $this->attr = $attr;
    }

    public function index(Request $request)
    {
        if($request->type == 'attr'){
            $datas = Attribute::where('types','LIKE', $request->type)->get();
            foreach ($datas as $index => $data)
            {
                $datas[$index]['option'] = Attribute::where('parent_id', $data['id'])->get();
            }
            return response()->json($datas);
        }

        return Attribute::where('types','LIKE', $request->type)->get();
    }

    public function show(Request $request)
    {
        if($request->type == 'list'){
            $data = Attribute::find((int)$request->id);
            $data['option'] = Attribute::where('parent_id', $data['id'])->get();
            return $data;
        }
        return Attribute::find($request->id);
    }

    public function store(Request $request)
    {
        $rule = [
            'name' => 'required',
            'types' => 'required',
            'format' => 'required'
        ];

        $this->validate($request, $rule);



        if($this->attr->duplicate($request)){
            return response()->json([
                'message' => 'Already exist'
            ]);
        }

        $attribute = Attribute::create($request->all());

        if($request->options){
            foreach ($request->options as $option)
            {
               $new = new Attribute();
               $new->name = $option['name'];
               $new->types = 'select';
               $new->format = $request->format;
               $new->parent_id = $attribute->id;
               $new->save();
            }

            return response()->json([
                'message' => "created attribute $attribute->name with parent options"
            ]);
        }

        return response()->json([
            'message' => "created attribute $attribute->name"
        ]);

    }

    public function update(Request $request)
    {
        return Attribute::where('id', $request->id)->update($request->only($this->attr->getFillable()));
    }

    public function destroy(Request $request)
    {
        return Attribute::where('id',$request->id)->delete();
    }
}
