<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubcategoriesHasTypes;
use App\Models\Subcategory;

class SubcategoriesHasTypesController extends Controller
{
    
    public function byType($type_id) {
        $subcategories = Subcategory::from('subcategories')
                                    ->select('subcategories.*')
                                    ->join('subcategories_has_types','subcategories.id','=','subcategories_has_types.subcategory_id')
                                    ->where('subcategories_has_types.type_id', $type_id)
                                    ->get();

        foreach ($subcategories as $key => $value) {
            $value->categories;
        }

        return response()->json($subcategories);
    }
        

}
