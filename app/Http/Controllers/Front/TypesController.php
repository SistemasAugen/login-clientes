<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Type;

class TypesController extends Controller
{
    public function index()
    {
        $types=Type::all();
        foreach ($types as $key => $value) {
            $value->categories;
        }

        return response()->json($types);
    }
}
