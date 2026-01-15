<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "producto";
    protected $primaryKey = "pro_id";
    /*
    ------------------------------------------------------------------------
    METODOS PARA RELACIONES
    ------------------------------------------------------------------------
     */
    //proveedor que corresponde al producto
    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'pro_id');
    }
    public function inventario(){
        return $this->hasOne(Inventario::class, 'pro_id');
    }
}
