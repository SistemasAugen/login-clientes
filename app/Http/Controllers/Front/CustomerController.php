<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
class CustomerController extends Controller
{
    public function orders()
    {
        
        $userId = Auth::user()->id;
        $rows = Order::where('client_id',$userId)->get();
        foreach ($rows as $key => $value) {
            $value->date = $value->created_at->format('d-m-Y H:i:s');
            $value->productHas;
            $value->extras;
            $value->client;
            $value->branch;

            $value->realTotal = '$' . number_format(floatval($value->total)  - floatval($value->discount) - floatval($value->discount_admin) + floatval($value->iva), 2);
            $value->created = $value->created_at->format('d-m-Y H:i:s');
        }
        return response()->json($rows);
    }
}
