<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Inventario;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ProductoController extends Controller
{
    private $modulo = "productos";
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        //verificar si esta logueado el producto
        if(!Auth::check()){return redirect('/');}

        $productos = Producto::all();      
        return view('productos.lista_productos', ['titulo'=>'Productos',
                                                          'productos' => $productos,
                                                          'modulo_activo' => $this->modulo
                                                         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //verificar si esta logueado el producto
        if(!Auth::check()){return redirect('/');}

        $titulo = 'NUEVO producto';
        $proveedores = Proveedor::all();

        return view('productos.form_nuevo_producto', ['titulo'=>$titulo, 
                                                    'modulo_activo' => $this->modulo,
                                                    'proveedores'=>$proveedores
                                                    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //verificar si esta logueado el producto
        if(!Auth::check()){return redirect('/');}

        //guardar producto
        $producto = new producto();
        $producto->pro_nombre = $request->input('pro_nombre');
        $producto->pve_id = $request->input('pve_id');
        $producto->pro_sku = $request->input('pro_sku');
        $producto->pro_descripcion = $request->input('pro_descripcion');
        $producto->pro_precio_venta = $request->input('pro_precio_venta');
        $producto->pro_precio_compra = $request->input('pro_precio_venta'); 
        $producto->pro_stock_minimo = $request->input('pro_stock_minimo'); 
        $producto->pro_estado = "activo"; //activo - ingreso
        $producto->save();

        $inventario = new Inventario();
        $inventario->pro_id = $producto->pro_id;
        $inventario->inv_cantidad = 0;
        $inventario->save();

        return redirect('productos');
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
        //verificar si esta logueado el producto
        if(!Auth::check()){return redirect('/');}

        $titulo = 'EDITAR producto';
        $id = Crypt::decryptString($id);//Desencriptando parametro ID
        $producto = Producto::where('pro_id', $id)->first();
        $proveedores = Proveedor::all();

        return view('productos.form_editar_producto', ['titulo'=>$titulo, 
                                                    'producto'=>$producto,
                                                    'modulo_activo' => $this->modulo,
                                                    'proveedores'=>$proveedores
                                                    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //verificar si esta logueado el producto
        if(!Auth::check()){return redirect('/');}

        //guardar producto
        $id = Crypt::decryptString($id);//Desencriptando parametro ID
        $producto = Producto::where('pro_id', $id)->first();
        $producto->pro_nombre = $request->input('pro_nombre');
        $producto->pve_id = $request->input('pve_id');
        $producto->pro_sku = $request->input('pro_sku');
        $producto->pro_descripcion = $request->input('pro_descripcion');
        $producto->pro_precio_venta = $request->input('pro_precio_venta');
        $producto->pro_precio_compra = $request->input('pro_precio_compra'); 
        $producto->pro_stock_minimo = $request->input('pro_stock_minimo'); 
        $producto->save();
        return redirect('productos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //verificar si esta logueado el producto
        if(!Auth::check()){return redirect('/');}

        $id = Crypt::decryptString($id);

        $inventario = Inventario::where('pro_id', $id)->first();
        $inventario->delete();
        
        $producto = Producto::where('pro_id', $id)->first();
        $producto->delete();
        return redirect('productos');
    }
}
