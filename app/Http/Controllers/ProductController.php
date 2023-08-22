<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ProductBreed;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\ProductImages;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Images;
use Documents;
// use App\Imports\ProductsImport;
// use Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Product::orderBy('id', 'desc')->get();
        foreach ($rows as $key => $value) {
            $value->image = Images::getImg($value->images_id);
        }
        return response()->json($rows);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $row = new Product();
        $row->sku = $request->sku;
        $row->name = $request->name;
        $row->description = $request->description;
        if ($request->file('image')) {
            $row->images_id = Images::save($request->file('image'));
        }
        if ($request->file('document')) {
            $row->documents_id = Documents::save($request->file('document'));
        }
        $row->brands_id = $request->brands_id;
        $row->high = $request->high;
        $row->long = $request->long;
        $row->width = $request->width; 
        $row->weigth = $request->weigth; 
        $row->save();

        if (sizeof($request->categories_id) > 0) {
            foreach ($request->categories_id as $key => $value) {
                $cat = new ProductCategory();
                $cat->products_id = $row->id;
                $cat->categories_id = $value;
                $cat->save();
            }
        }
        if (sizeof($request->subcategories_id) > 0) {
            foreach ($request->subcategories_id as $key => $value) {
                $subcat = new ProductSubcategory();
                $subcat->products_id = $row->id;
                $subcat->subcategories_id = $value;
                $subcat->save();
            }
        }
        if (sizeof($request->breeds_id) > 0) {
            foreach ($request->breeds_id as $key => $value) {
                $subcat = new ProductBreed();
                $subcat->products_id = $row->id;
                $subcat->breeds_id = $value;
                $subcat->save();
            }
        }
        return response()->json($row);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Product::find($id);
        $row->imageUrl = Images::getUrl($row->images_id);
        $row->documentUrl = Documents::getUrl($row->documents_id);
        $row->categories_id = ProductCategory::where('products_id',$id)->pluck('categories_id');
        $row->subcategories_id = ProductSubcategory::where('products_id',$id)->pluck('subcategories_id');
        $row->breeds_id = ProductBreed::where('products_id',$id)->pluck('breeds_id');
        $images = ProductImages::where('products_id',$id)->get();
        foreach ($images as $key => $value) {
            $value->url = Images::getUrl($value->images_id);
        }
        $row->images = $images;
        return response()->json($row);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $row = Product::find($id);
        $row->sku = $request->sku;
        $row->name = $request->name;
        $row->description = $request->description;
        if ($request->file('image')) {
            if ($row->images_id != null) {
                Images::delete($row->images_id);
            }
            $row->images_id = Images::save($request->file('image'));
        }
        if ($request->file('document')) {
            if ($row->documents_id != null) {
                Documents::delete($row->documents_id);
            }
            $row->documents_id = Documents::save($request->file('document'));
        }
        $row->brands_id = $request->brands_id;
        $row->high = $request->high;
        $row->long = $request->long;
        $row->width = $request->width; 
        $row->weigth = $request->weigth; 
        $row->save();

        if (sizeof($request->categories_id) > 0) {
            ProductCategory::where('products_id',$row->id)->delete();
            foreach ($request->categories_id as $key => $value) {
                $cat = new ProductCategory();
                $cat->products_id = $row->id;
                $cat->categories_id = $value;
                $cat->save();
            }
        }
        else{
            ProductCategory::where('products_id',$row->id)->delete();
        }
        if (sizeof($request->subcategories_id) > 0) {
            ProductSubcategory::where('products_id',$row->id)->delete();
            foreach ($request->subcategories_id as $key => $value) {
                $subcat = new ProductSubcategory();
                $subcat->products_id = $row->id;
                $subcat->subcategories_id = $value;
                $subcat->save();
            }
        }
        else{
            ProductSubcategory::where('products_id',$row->id)->delete();
        }
        if (sizeof($request->breeds_id) > 0) {
            ProductBreed::where('products_id',$row->id)->delete();
            foreach ($request->breeds_id as $key => $value) {
                $subcat = new ProductBreed();
                $subcat->products_id = $row->id;
                $subcat->breeds_id = $value;
                $subcat->save();
            }
        }
        else{
            ProductBreed::where('products_id',$row->id)->delete();
        }

        return response()->json($row);
    }

    public function import(Request $request)
    {
        try{
            Excel::import(new ProductsImport, request()->file('file'));
            return response()->json(['msg'=>'La importación ha finalizado exitosamente!.']);   

        }catch (\Exception $e) {
            return $e;
            return response()->json(['msg'=>'Ocurrio un error', 'error' => $e],500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->_delete($id)){
            return response()->json(['msg'=>'registro con ID '.$id.' eliminado.']);
        }
        else{
            return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
        }
    }

    public function destroyMultiple(Request $request)
    {
        foreach ($request->ids as $key => $value) {
            $status=$this->_delete($value);
            if(!$status)
                break;
        }

        if ($status) {
            return response()->json(['msg'=>'Registros eliminados.']);
        }
        else{
            return response()->json(['msg'=>'Ocurrio un error al eliminar.'],500);
        }
    }

    private function _delete($id)
    {
        $temp = Product::find($id);

        if ($temp->delete()) {
            return true;
        }
        else{
            return false;
        }
    }

    public function uploadImage(Request $request, $id)
    {
        ini_set('memory_limit',-1);
        if($request->has('file'))
        {
            $imagep = new ProductImages();
            $imagep->products_id = $id;
            $imagep->images_id = Images::save($request->file('file'));
            $imagep->save();
        }

        return response()->json('Imagen cargada!');
    }
    public function deleteImage($id)
    {
        ProductImages::where('id', $id)->delete();
        return response()->json(array("msg" => 'Imagen eliminada'));
    }
}
