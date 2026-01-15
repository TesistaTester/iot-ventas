<?php

use App\Http\Controllers\AlertaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ReporteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
----------------------------------------
* RUTAS: PÚBLICAS
----------------------------------------
*/
Route::get('/', function () {
    return view('publico.login', ['titulo'=>'Acceso al sistema']);
});

Route::get('/mail', function () {
    return view('intro', ['grado'=>2]);
});

/*
----------------------------------------
* RUTAS: AUTENTICACIÓN
----------------------------------------
*/
Route::get('/logout', [AuthController::class ,'logout']);
Route::post('/auth', [AuthController::class ,'autenticar']);
// Route::resource('/auth', AuthController::class);

/*
----------------------------------------
* RUTAS: DASHBOARD
----------------------------------------
*/
Route::resource('/dashboard', DashboardController::class);

/*
----------------------------------------
* RUTAS: VENTAS
----------------------------------------
*/
Route::get('/ventas/{ven_id}/detalle', [VentaController::class ,'detalle_venta']);
Route::resource('/ventas', VentaController::class);

/*
----------------------------------------
* RUTAS: PRODUCTOS
----------------------------------------
*/
Route::resource('/productos', ProductoController::class);

/*
----------------------------------------
* RUTAS: PROVEEDORES
----------------------------------------
*/
Route::resource('/proveedores', ProveedorController::class);

/*
----------------------------------------
* RUTAS: INVENTARIO
----------------------------------------
*/
Route::post('/inventario/guardar_seguir', [InventarioController::class ,'guardarSeguir']);
Route::post('/inventario/guardar_terminar', [InventarioController::class ,'guardarTerminar']);
Route::get('/inventario/altas/{inv_id}', [InventarioController::class ,'alta']);
Route::get('/inventario/lectura_qr', [InventarioController::class ,'lecturaQr']);
// Route::get('/inventario/lectura_entrega', [InventarioController::class ,'lectura_pos']);
Route::resource('/inventario', InventarioController::class);

/*
----------------------------------------
* RUTAS: CLIENTES
----------------------------------------
*/
Route::resource('/clientes', ClienteController::class);
/*
----------------------------------------
* RUTAS: USUARIOS
----------------------------------------
*/
Route::resource('/usuarios', UsuarioController::class);

/*
----------------------------------------
* RUTAS: MODULOS RFID
----------------------------------------
*/
// Route::resource('/modulos-rfid', ModuloLecturaController::class);


/*
----------------------------------------
* RUTAS: REPORTES
----------------------------------------
*/
Route::get('/reportes/stock_critico', [ReporteController::class ,'stockCritico']);
Route::get('/reportes/ventas_mensual', [ReporteController::class ,'ventasMensual']);
Route::get('/reportes/inventario_log', [ReporteController::class ,'inventarioLog']);
Route::get('/reportes/inventario_actual', [ReporteController::class ,'inventarioActual']);
Route::resource('/reportes', ReporteController::class);

