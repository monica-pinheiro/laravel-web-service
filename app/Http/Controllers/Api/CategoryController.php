<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategoryFormRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index(Category $category, Request $request){
        $categories = $category -> getResults($request->name);
        return response()->json($categories);
    }

    public function show($id){
        if(!$category = $this->category->find($id))
            return response()->json(['error'=>'Not Found'], 404);

        return response()->json($category,200);
    }

    public function store(StoreUpdateCategoryFormRequest $request){
        $category = $this->category->create($request->all());
        return response()->json($category, 201);
    }
    public function update(StoreUpdateCategoryFormRequest $request, $id){

        if(!$category = $this->category->find($id))
            return response()->json(['error'=>'Not Found'], 404);

        $category = $this->category->find($id);
        $category->update($request->all());

        return response()->json($category, 200);
    }

   /* public function delete($id){

        if(!$category = $this->category->find($id))
            return response()->json(['error'=>'Not Found'], 404);

        $category->delete();

        return response()->json(['success'=>true], 200);
    }*/

    public function destroy($id){

        if(!$category = $this->category->find($id))
            return response()->json(['error'=>'Not Found'], 404);

        $category->delete();

        return response()->json(['success'=>true], 200);
    }

    public function products($id){
        if(!$category = $this->category->with(['products'])->find($id))
            return response()->json(['error'=>'Not Found'], 404);

        $products = $category->products;

        return response()->json(
            [
                'category' => $category,
                'product' => $products,
            ]
        );
    }
}
