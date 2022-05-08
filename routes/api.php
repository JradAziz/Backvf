<?php
use App\Http\Controllers\TokenController;
use App\Http\Controllers\JirabcpController;
use App\Http\Controllers\TransferdataController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [TokenController::class, 'login'])->name('login');
Route::post('/getcloseddata', [JirabcpController::class, 'getcloseddata'])->name('getcloseddata');
Route::post('/getuserteamid', [JirabcpController::class, 'getuserteamid'])->name('getuserteamid');
Route::post('/getuserteammates', [JirabcpController::class, 'getuserteammates'])->name('getuserteammates');
Route::post('/changetaskstatus', [JirabcpController::class, 'changetaskstatus'])->name('changetaskstatus');
Route::post('/getdata', [JirabcpController::class, 'getdata'])->name('getdata');
Route::get('/index', [TransferdataController::class, 'index'])->name('index');
Route::get('/post', [TransferdataController::class, 'send'])->name('send');




;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    Route::post('/login', [TokenController::class, 'login'])->name('login');

});