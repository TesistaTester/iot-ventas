<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\ProductoTagRFID;
use App\Models\Producto;
use App\Models\InventarioLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InventarioController extends Controller
{
    private $modulo = "inventario";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //verificar si esta logueado el usuario
        if(!Auth::check()){return redirect('/');}

        $inventario = Inventario::all();      
        $log_inventario = InventarioLog::all();
        return view('inventario.lista_inventario', ['titulo'=>'Inventario',
                                                          'log_inventario' => $log_inventario,
                                                          'inventario' => $inventario,
                                                          'modulo_activo' => $this->modulo
                                                         ]);
    }

    //esta funcion detecta si existe un tag rfid sin asignar y retorna en json si existe o no
    //este es consultado por el circuito lector de tags rfid
    public function existeTagSinAsignar()
    {
        //Verificamos si existe algun tag rfid sin asignar en la tabla producto_tag_rfid
        $tags_sin_asignar = ProductoTagRFID::where('ptr_estado', 'inicializado')->get()->toArray();
        if(count($tags_sin_asignar) > 0){
            return response()->json(['status'=>'1', 'mensaje'=>'Existe tag sin asignar']);
        }else{
            return response()->json(['status'=>'0', 'mensaje'=>'No existe tag sin asignar']);
        }
    }
    //esta funcion procesa una peticion post desde el sensor que envia el uid del tag rfid leido
    public function procesarTagSinAsignar(Request $request)
    {
        $uid_capturado = $request->input('uid');
        //obtenemos el tag sin asignar
        $tag_sin_asignar = ProductoTagRFID::where('ptr_estado', 'inicializado')->first();
        //asignamos el uid capturado al tag sin asignar
        $tag_sin_asignar->ptr_uid = $uid_capturado;
        $tag_sin_asignar->ptr_estado = "asignado";
        $tag_sin_asignar->save();

        return response()->json(array('status'=>'1', 'mensaje'=>'Tag asignado correctamente'));
    }
    //esta funcion detecta si hay un tag con estado asignado y responde con json si hay o no
    //este es consultado por el frontend
    public function existeTagAsignado()
    {
        //Verificamos si existe algun tag rfid sin asignar en la tabla producto_tag_rfid
        $tags_asignados = ProductoTagRFID::where('ptr_estado', 'asignado')->get()->toArray();
        if(count($tags_asignados) > 0){
            return response()->json(array('status'=>'1', 'mensaje'=>'Existe tag asignado', 'tag'=>$tags_asignados[0]));
        }else{
            return response()->json(array('status'=>'0', 'mensaje'=>'No existe tag asignado'));
        }
    }

    //esta funcion procesa una peticion post desde el frontend para cambiar el estado de un tag asignado y ponerle el pro_id
    public function guardarSeguir(Request $request){
        //obtenemos el tag asignado
        $tag_asignado = ProductoTagRFID::where('ptr_id', $request->input('ptr_id'))->first();
        //asignamos el pro_id al tag asignado
        $tag_asignado->pro_id = $request->input('pro_id');
        $tag_asignado->ptr_estado = "activo";
        $tag_asignado->save();

        return redirect('/inventario/altas/'.$tag_asignado->inv_id);
    }

    public function guardarTerminar(Request $request){
        //obtenemos el tag asignado
        $tag_asignado = ProductoTagRFID::where('ptr_id', $request->input('ptr_id'))->first();
        //asignamos el pro_id al tag asignado
        $tag_asignado->pro_id = $request->input('pro_id');
        $tag_asignado->ptr_estado = "activo";
        $tag_asignado->save();

        return redirect('/inventario');
    }
    

    public function alta($inv_id)
    {
        //verificar si esta logueado el usuario
        if(!Auth::check()){return redirect('/');}

        //obtenemos el producto con inv_id
        $inventario = Inventario::find($inv_id);

        //Verificamos si existe algun tag rfid sin asignar en la tabla producto_tag_rfid
        $tags_sin_asignar = ProductoTagRFID::where('ptr_estado', 'inicializado')->orWhere('ptr_estado', 'asignado')->get();
        if(count($tags_sin_asignar) > 0){
            //procedemos a limpiar los tags sin asignar
            foreach($tags_sin_asignar as $tag){
                //eliminamos los tags sin asignar
                $tag->delete();
            }
        }

        //crear un tag rfid nuevo
        $nuevo_tag = new ProductoTagRFID();
        $nuevo_tag->inv_id = $inventario->inv_id;
        $nuevo_tag->pro_id = $inventario->pro_id;
        //asignamos un uid provisional            
        $nuevo_tag->ptr_uid = "UID-".time();
        //asignamos un qr/barcode provisional
        $nuevo_tag->ptr_codigo = "QR-".time();
        $nuevo_tag->ptr_estado = "inicializado";
        $nuevo_tag->save();

        //trabajamos con un solo tag sin asignar        
        return view('inventario.alta_tag', ['titulo'=>'Alta de item en inventario',
                                              'nuevo_item' => $nuevo_tag,
                                            'modulo_activo' => $this->modulo
                                                         ]);
    }

    public function lecturaQr()
    {
        //verificar si esta logueado el usuario
        // if(!Auth::check()){return redirect('/');}

        return view('inventario.qr-lector', ['titulo'=>'QR Lector',
                                                          'modulo_activo' => $this->modulo
                                                         ]);
    }


    public function lectura_almacen(Request $request){
        $uid = $request->input('uid');
        $evento = $request->input('evento');
        //obtenemos el tag con uid capturado
        $tag = ProductoTagRFID::where('ptr_uid', $request->uid)->first();
        //obtenemos el producto cuyo tag corresponde
        $producto = Producto::find($tag->pro_id);
        //registramos el movimiento en inventarioLog
        $movimiento = new InventarioLog();
        $movimiento->pro_id = $producto->pro_id;
        $movimiento->ilo_tipo_movimiento = $evento; // entrada/salida
        $movimiento->ilo_cantidad = 1; // Una máquina por tag
        $movimiento->ilo_fuente = 'iot';
        $movimiento->ilo_descripcion = "Movimiento automático por RFID";
        $movimiento->save();

        //Actualizamos inventario
        $inventario = Inventario::where('pro_id', $producto->pro_id)->first();
        if ($evento === 'entrada') {
            $inventario->inv_cantidad += 1;
        } else {
            $inventario->inv_cantidad -= 1;
        }
        $inventario->save();

        // return response()->json(array('status'=>'1', 'lecturas'=>'Saludo a esp32'));
        return response('----> LECTURA PROCESASA DESDE LARAVEL Uid:'.$uid.' Evento: '.$evento);
    }

    public function lectura_pos(Request $request){
        $uid = $request->input('uid');
        $evento = $request->input('evento');
        return response()->json(array('status'=>'1', 'uid'=>$uid, 'tipo'=> $evento));
    }

    // public function lectura_entrega(Request $request){
    //     $uid = $request->input('uid');
    //     $evento = $request->input('evento');

    //     //obtenemos el tag con uid capturado
    //     $tag = ProductoTagRFID::where('ptr_uid', $request->uid)->first();
    //     //obtenemos el producto cuyo tag corresponde
    //     $producto = Producto::find($tag->pro_id);
    //     //obtenemos el detalle de producto en venta cuyo despacho este pendiente
    //     $detalle = DetalleVenta::where('pro_id', $producto->pro_id)->where('dve_despachos', 0)->first();
    //     $detalle->dve_despachados = $detalle->dve_despachados + 1;
    //     $detalle->save();
    //     //revisamos todos los despachos para cambiar el estado del pedido a despachado
    //     $dets = DetalleVenta::where('pro_id', $producto->pro_id)->get();
    //     $nro_dets = count($dets);
    //     $nro_dets_despacho = 0;
    //     foreach($dets as $item){
    //         if($item->dve_cantidad == $item->dve_despachos){
    //             $nro_dets_despacho += 1;
    //         }
    //     }
    //     if($nro_dets == $nro_dets_despacho){
    //         $venta = Venta::where('ven_id', $detalle->ven_id);
    //     }

    //     return response()->json(array('status'=>'1', 'uid'=>$uid, 'tipo'=> $evento));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
