<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use DB;
class ProductsController extends Controller
{
    public function type($type_id)
    {
        $products = Product::where('type_id', $type_id)->get();

        foreach ($products as $key => $value) {
            $value->subcategories;
            $value->prices = DB::table('product_has_subcategories')->whereIn('id', function($query) use ($value) {
                $query->selectRaw('MAX(id)')
                      ->from('product_has_subcategories')
                      ->where('product_id', $value->id)
                      ->groupBy('subcategory_id', 'type_id', 'category_id');
            })->get();
            // $value->prices;
            $value->extras;
        }
        return response()->json($products);
    }
}
