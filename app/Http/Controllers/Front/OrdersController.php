<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

use App\Models\Order;
use App\Models\Purchase;
use App\Models\OrderHasExtra;

use App\Mail\RequestRx;

class OrdersController extends Controller
{
    public function store(Request $request)
    {
       
        $user=Auth::user();
        $user->branch;
        /*if(!isset($user->branch->laboratory)){
            return response()->json(['msg'=>'No puedes realizar pedidos, contacta al administrador.'],500);
        }*/
         
        $purchase=new Purchase(array(
            "user_id"=>$user->id,
            "client_id"=>$request->client_id,
            "total"=>$request->total,
            "description"=>$request->observation
        ));
        $purchase->save();

        foreach ($request->cart as $key => $value) {
            $order = new Order(array(
                "purchase_id"=>$purchase->id,
                "product_has_subcategory_id"=>$value['product_has_subcategory_id'],
                "price"=>$value['price'],
                "discount"=>$value['discount'],
                "discount_percent"=>$value['percent_discount'],
                "service"=>$value['service'],
                "total"=>$value['total'],
                "iva"=>$value['iva'],
                "rx"=>$value['rx'],
                "laboratory_id"=>$user->branch->laboratory->id,
                "branch_id"=>$user->branch->id,
                "client_id"=>$request->client_id,

                "rx_rx" => $value['rx_data']['rx_rx'] ? $value['rx_data']['rx_rx'] : null,
                "rx_fecha" => $value['rx_data']['rx_fecha'] ? $value['rx_data']['rx_fecha'] : null,
                "rx_cliente" => $value['rx_data']['rx_cliente'] ? $value['rx_data']['rx_cliente'] : null,

                "rx_od_esfera" => $value['rx_data']['rx_od_esfera'] ? $value['rx_data']['rx_od_esfera'] : null,
                "rx_od_cilindro" => $value['rx_data']['rx_od_cilindro'] ? $value['rx_data']['rx_od_cilindro'] : null,
                "rx_od_eje" => $value['rx_data']['rx_od_eje'] ? $value['rx_data']['rx_od_eje'] : null,
                "rx_od_adicion" => $value['rx_data']['rx_od_adicion'] ? $value['rx_data']['rx_od_adicion'] : null,
                "rx_od_dip" => $value['rx_data']['rx_od_dip'] ? $value['rx_data']['rx_od_dip'] : null,
                "rx_od_altura" => $value['rx_data']['rx_od_altura'] ? $value['rx_data']['rx_od_altura'] : null,
                

                "rx_od_esfera_dos" => $value['rx_data']['rx_od_esfera_dos'] ? $value['rx_data']['rx_od_esfera_dos'] : null,
                "rx_od_cilindro_dos" => $value['rx_data']['rx_od_cilindro_dos'] ? $value['rx_data']['rx_od_cilindro_dos'] : null,
                "rx_od_eje_dos" => $value['rx_data']['rx_od_eje_dos'] ? $value['rx_data']['rx_od_eje_dos'] : null,
                "rx_od_adicion_dos" => $value['rx_data']['rx_od_adicion_dos'] ? $value['rx_data']['rx_od_adicion_dos'] : null,
                "rx_od_dip_dos" => $value['rx_data']['rx_od_dip_dos'] ? $value['rx_data']['rx_od_dip_dos'] : null,
                "rx_od_altura_dos" => $value['rx_data']['rx_od_altura_dos'] ? $value['rx_data']['rx_od_altura_dos'] : null,
            
                "rx_diseno" => $value['rx_data']['rx_diseno'] ? $value['rx_data']['rx_diseno'] : null,
                "rx_material" => $value['rx_data']['rx_material'] ? $value['rx_data']['rx_material'] : null,
                "rx_tipo_ar" => $value['rx_data']['rx_tipo_ar'] ? $value['rx_data']['rx_tipo_ar'] : null,
                "rx_tallado" => $value['rx_data']['rx_tallado'] ? $value['rx_data']['rx_tallado'] : null,
                "rx_tipo_armazon" => $value['rx_data']['rx_tipo_armazon'] ? $value['rx_data']['rx_tipo_armazon'] : null,
                "rx_horizontal_a" => $value['rx_data']['rx_horizontal_a'] ? $value['rx_data']['rx_horizontal_a'] : null,
                "rx_vertical_b" => $value['rx_data']['rx_vertical_b'] ? $value['rx_data']['rx_vertical_b'] : null,
                "rx_diagonal_ed" => $value['rx_data']['rx_diagonal_ed'] ? $value['rx_data']['rx_diagonal_ed'] : null,
                "rx_puente" => $value['rx_data']['rx_puente'] ? $value['rx_data']['rx_puente'] : null,
                "rx_observaciones" => $value['rx_data']['rx_observaciones'] ? $value['rx_data']['rx_observaciones'] : null,
                
            ));

            $actualTotal = floatval($value['total']) - floatval($value['discount']);

            $order->iva = $this->_recalculateTax($actualTotal, $order->laboratory_id, $order->iva);
            $order->save();

            if($value['extras']) {
                foreach ($value['extras'] as $k => $v) {
                    OrderHasExtra::create(array(
                        "order_id"=>$order->id,
                        "extra_id"=>$v['extra_id'],
                        "price"=>$v['price'],
                    ));
                }
            }

            // if Order object is an Augen Mask it must be on ENTREGADO inmediatly
            if (strpos($order->rx, 'AM-') !== false) {
                $order->finish_date = date('Y-m-d');
                $order->delivered_date = date('Y-m-d');
                $order->status = 'entregado';
                $order->save();
            }
        }

        return response()->json(['msg'=>'Pedido generado correctamente!!']);
    }
    private function _recalculateTax($total, $laboratory_id, $actualTax) {
        // $client = Client::findOrFail($client_id);
        // $zipCode = $client->facturacion->postal_code;

        if(!isset($laboratory_id) || is_null($laboratory_id))
            return $actualTax;
        return in_array($laboratory_id, [2, 10]) ? (floatval($total) * 0.08) : $actualTax;
    }


    public function checkDuplicate($rx) {
        $today = date('Y-m-d');
        $order = Order::where('rx', $rx)
                      ->whereRaw("DATE(created_at) = '$today'")
                      ->first();
        
        if(!is_null($order)){
            return response()->json(true);
        }
        return response()->json(false);
    }

    public function requestRxSave(Request $request)
    {
        ini_set('memory_limit', '-1');
        $data = $request->rx;
        if (isset($request->user['branch'])) {
            $data['pdv'] = $request->user['branch']['name'];
        }
        if ($data) {
            $pdf = PDF::loadView('plantillas.requestrx',['inputs' => $data]);
            $content = $pdf->download()->getOriginalContent();
             // Crear el archivo y almacenarlo en el storage
            Storage::disk('public')->put('docs/order-aaaa.pdf',$content);

            if (isset($request->user['email'])) {
                Mail::to($request->user['email'])->send(new RequestRx( $data,$content));
                //Mail::to('richardsustam23@gmail.com')->send(new RequestRx( $data,$content));
            }
        }
        return 'ok';
    }
}
