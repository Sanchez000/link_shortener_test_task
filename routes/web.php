<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProxyLinkController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [LinkController::class , 'create']);
Route::resource('links', LinkController::class)->only(['create', 'store', 'show']);
Route::get('/{shortCode}' , [ProxyLinkController::class , 'show'])
    ->where('shortCode', '(.*){'.config('services.code.length').'}');