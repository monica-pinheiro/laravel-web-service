<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateProductFormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\HttpCache\Store;

class ProductController extends Controller
{

    private $product;
    private $totalPage = 10;
    private $path = 'products';

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        //$products = $this->product->get();
        //$products = $this->product->paginate($this->totalPage);
        //return response()->json($products);

        $products = $this->product->getResults($request->all(), $this->totalPage);
        return response()->json($products);
    }


    public function create()
    {
        //
    }


    public function store(StoreUpdateProductFormRequest $request)
    {
        $data = $request->all();

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $name = Str::kebab($request->name);
            $extension = $request->image->extension();
            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;
            $upload = $request->image->storeAs($this->path,$nameFile);

            if(!$upload){
                return response()->json(['error'=>'Falha no Upload'], 500);
            }
        }

        $product = $this->product->create($data);
        return response()->json($product, 201);
    }


    public function show($id)
    {
        if(!$product = $this->product->with(['category'])->find($id))
            return response()->json(['error'=>'Not Found'], 404);

        return response()->json($product);
    }

    public function edit($id)
    {
        //
    }


    public function update(StoreUpdateProductFormRequest $request, $id)
    {
        if(!$product = $this->product->find($id))
            return response()->json(['error'=>'Not Found'], 404);

        $data = $request->all();

        if($request->hasFile('image') && $request->file('image')->isValid()){

            if($product->image){
                if(Storage::exists("$this->path/{$product->image}")){
                    Storage::delete("$this->path/{$product->image}");
                }
            }

            $name = Str::kebab($request->name);
            $extension = $request->image->extension();
            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;
            $upload = $request->image->storeAs($this->path,$nameFile);

            if(!$upload){
                return response()->json(['error'=>'Falha no Upload'], 500);
            }
        }
        else{
            Storage::delete("$this->path/{$product->image}");
            $nameFile = "";
            $data['image'] = $nameFile;
        }

        //$product = $this->product->find($id);
        $product->update($data);

        return response()->json($product, 200);
    }


    public function destroy($id)
    {
        if(!$product = $this->product->find($id))
            return response()->json(['error'=>'Not Found'], 404);

        if($product->image){
            if(Storage::exists("$this->path/{$product->image}")){
                Storage::delete("$this->path/{$product->image}");
            }
        }

        $product->delete();

        return response()->json(['success'=>true], 200);
    }
}
