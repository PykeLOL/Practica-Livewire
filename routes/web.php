<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\ClickEvent;
use App\Http\Controllers\PasarelaController;
use App\Http\Controllers\PayUMoneyController;
use App\Http\Controllers\FutbolController;

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

Route::get('/', ClickEvent::class)->name('index');

Route::get('/PayU', [PasarelaController::class, 'index'])->name('pasarela.index');
Route::post('/PayU', [PasarelaController::class, 'PagarPayU'])->name('pasarela.pagar');

Route::get('pay-u-money-view',[PayUMoneyController::class,'payUMoneyView']);
Route::get('pay-u-response',[PayUMoneyController::class,'payUResponse'])->name('pay.u.response');
Route::get('pay-u-cancel',[PayUMoneyController::class,'payUCancel'])->name('pay.u.cancel');

Route::get('/futbol', [FutbolController::class, 'index'])->name('futbol.index');
Route::get('/futbol/publicidad', [FutbolController::class, 'publicidad'])->name('futbol.publicidad');
Route::post('/futbol/publicidad', [FutbolController::class, 'addPublicidad'])->name('futbol.addpublicidad');
Route::put('/futbol/publicidad/{publicidad}', [FutbolController::class, 'editPublicidad'])->name('futbo.editpublicidad');
Route::delete('/futbol/publicidad/{publicidad}', [FutbolController::class, 'destroyPublicidad'])->name('futbol.destroypublicidad');
Route::get('/Pagar/{id}', [FutbolController::class, 'pasarela'])->name('pasarela.publicidad');
Route::get('/respuesta-pago', [FutbolController::class, 'respuestaPago'])->name('respuesta_pago');


