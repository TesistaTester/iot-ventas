<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = "proveedor";
    protected $primaryKey = "pve_id";
    /*
    ------------------------------------------------------------------------
    METODOS PARA RELACIONES
    ------------------------------------------------------------------------
     */
    //productos que corresponden al proveedor
    public function productos(){
        return $this->hasMany(Producto::class, 'pve_id');
    }
}
