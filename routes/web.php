<?php
use App\Http\Controllers\KonfirmasiCont;
use App\Http\Controllers\DiklatCont;
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

Route::get('/', function () {
    // return view('welcome');
    // return redirect()->away('http://konfirmasi.nurulfalah.org');
    // return Redirect::to('http://konfirmasi.nurulfalah.org');
});

//peserta
Route::get('/',[KonfirmasiCont::class, 'index'])->name('index.e_confirm');
Route::get('/data-peserta',[KonfirmasiCont::class,'data_peserta_diklat_menunggu_konfirmasi'])->name('data_peserta');
Route::post('/konfirmasi-data-peserta-acc',[KonfirmasiCont::class,'acc'])->name('acc');
Route::get('/diklat-diklat-cabang-select',[KonfirmasiCont::class, 'diklat_cabang_select'])->name('diklat.diklat_cabang_select');
Route::get('/daftar/peserta/{cabang_id}',[KonfirmasiCont::class,'daftar_peserta']);


//diklat
Route::get('/seluruh-diklat',[DiklatCont::class, 'index'])->name('seluruh.diklat');
Route::get('/data-diklat',[DiklatCont::class, 'data_diklat'])->name('data_diklat');

//webinar
Route::get('/seluruh-webinar',[DiklatCont::class, 'index2'])->name('seluruh.webinar');
Route::get('/data-webinar',[DiklatCont::class, 'data_webinar'])->name('data_webinar');

//peserta di dalam webinar dan diklat
Route::get('/data-peserta/{pelatihan_id}',[DiklatCont::class, 'data_peserta']);
Route::get('/daftar-data-peserta/{pelatihan_id}',[DiklatCont::class, 'daftar_data_peserta']);

//send message wa blas (semua peserta)
Route::post('/broadcasr-wa',[KonfirmasiCont::class,'broadcastWA'])->name('wa.broadcast');

//broadcast
Route::get('/page-broadcast',[DiklatCont::class, 'page_broadcast'])->name('broadcast');
Route::get('/daftar-broadcast',[DiklatCont::class, 'daftar_broadcast']);

Route::post('/buka-tutup-diklat',[DiklatCont::class, 'buka_tutup'])->name('buka.tutup');