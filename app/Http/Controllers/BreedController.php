<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Breed;
use Images;

class BreedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Breed::orderBy('id', 'desc')->get();
        foreach ($rows as $key => $value) {
            $value->image = Images::getImg($value->images_id);
        }
        return $rows; 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $row = new Breed();
        $row->name = $request->name;
        if ($request->file('image')) {
            $row->images_id = Images::save($request->file('image'));
        }
        $row->save();

        return $row;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Breed::find($id);
        $row->imageUrl = Images::getUrl($row->images_id);
        return $row;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $row = Breed::find($id);
        $row->name = $request->name;
        if ($request->file('image')) {
            if ($row->images_id != null) {
                Images::delete($row->images_id);
            }
            $row->images_id = Images::save($request->file('image'));
        }
        $row->save();

        return $row;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->_delete($id)){
            return response()->json(['msg'=>'Registro con ID '.$id.' eliminado.']);
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
        $temp = Breed::find($id);
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
}
