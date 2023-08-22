<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use Images;
class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Subcategory::with('category')->orderBy('id', 'desc')->get();
        foreach ($subcategories as $key => $value) {
            $value->image = Images::getImg($value->images_id);
        }
        return response()->json($subcategories);
    }

    public function store(Request $request)
    {
        $subcategoria = new Subcategory();
        $subcategoria->name = $request->name;
        $subcategoria->category_id = $request->category_id ? $request->category_id : null;
        if ($request->file('image')) {
            $subcategoria->images_id = Images::save($request->file('image'));
        }
        $subcategoria->save();

        return response()->json($subcategoria);
    }

    public function show($id)
    {
        $subcategoria = Subcategory::find($id);
        $subcategoria->imageUrl = Images::getUrl($subcategoria->images_id);
        return response()->json($subcategoria);
    }

    public function update(Request $request, $id)
    {
        $subcategoria = Subcategory::find($id);
        $subcategoria->name = $request->name;
        $subcategoria->category_id = $request->category_id ? $request->category_id : null;
        if ($request->file('image')) {
            if ($subcategoria->images_id != null) {
                Images::delete($subcategoria->images_id);
            }
            $subcategoria->images_id = Images::save($request->file('image'));
        }
        $subcategoria->save();

        return response()->json($subcategoria);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $subcategoria
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
        $temp = Subcategory::find($id);
        if ($temp->images_id != null) {
            Images::delete($temp->images_id);
        }
        if ($temp->delete()) {
            return true;
        }
        else{
            return false;
        }
    }

    public function getSubcategories(Request $request)
    {
        
        $data = [];
       
        $subcategories = Subcategory::whereIn('category_id', $request->ids)->get();
            

        return $subcategories;
    }
}
