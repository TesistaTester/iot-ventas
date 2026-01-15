<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ProveedorController extends Controller
{
    private $modulo = "proveedores";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //verificar si esta logueado el usuario
        // if(!Auth::check()){return redirect('/');}

        $proveedores = Proveedor::all();      
        return view('proveedores.lista_proveedores', ['titulo'=>'proveedores',
                                                          'proveedores' => $proveedores,
                                                          'modulo_activo' => $this->modulo
                                                         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //verificar si esta logueado el proveedor
        if(!Auth::check()){return redirect('/');}

        $titulo = 'NUEVO proveedor';

        return view('proveedores.form_nuevo_proveedor', ['titulo'=>$titulo, 
                                                    'modulo_activo' => $this->modulo,
                                                    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //verificar si esta logueado el producto
        if(!Auth::check()){return redirect('/');}

        //guardar proveedor
        $proveedor = new Proveedor();
        $proveedor->pve_nombre = $request->input('pve_nombre');
        $proveedor->pve_nit = $request->input('pve_nit');
        $proveedor->pve_telefono = $request->input('pve_telefono');
        $proveedor->pve_email = $request->input('pve_email');
        $proveedor->pve_direccion = $request->input('pve_direccion');
        $proveedor->save();

        return redirect('proveedores');
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

        $titulo = 'EDITAR proveedor';
        $id = Crypt::decryptString($id);//Desencriptando parametro ID
        $proveedor = Proveedor::where('pve_id', $id)->first();
        $proveedores = Proveedor::all();

        return view('proveedores.form_editar_proveedor', ['titulo'=>$titulo,
                                                    'proveedor'=>$proveedor,
                                                    'modulo_activo' => $this->modulo,
                                                    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //verificar si esta logueado el producto
        if(!Auth::check()){return redirect('/');}

        //guardar proveedor
        $id = Crypt::decryptString($id);//Desencriptando parametro ID
        $proveedor = Proveedor::where('pve_id', $id)->first();
        $proveedor->pve_nombre = $request->input('pve_nombre');
        $proveedor->pve_nit = $request->input('pve_nit');
        $proveedor->pve_telefono = $request->input('pve_telefono');
        $proveedor->pve_email = $request->input('pve_email');
        $proveedor->pve_direccion = $request->input('pve_direccion');
        $proveedor->save();

        return redirect('proveedores');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //verificar si esta logueado el producto
        if(!Auth::check()){return redirect('/');}

        $id = Crypt::decryptString($id);

        $proveedor = Proveedor::where('pve_id', $id)->first();
        $proveedor->delete();
        return redirect('proveedores');
    }
}
