<?php

use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;

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
    return view('welcome');
});

/*
Route::get('/enviarEmail', function () {
    return view('formEmail');
});
*/

Route::get('view-form', [EmailController::class, 'formEmail'])->name('form.email');
//Route::get('enviar/email', [EmailController::class, 'enviarEmail'])->name('email.enviar');
Route::post('enviar/email', [EmailController::class, 'send'])->name('email.enviar');
Route::post('enviar/multipleEmail', [EmailController::class, 'getParams'])->name('email.multipleSend');

/*
Route::get('/testEmail', function(){
    $data = ['message' => 'This is a test!'];
    Mail::to('em2952.josearturodelosangeles.com')->send(new TestEmail($data));
});
*/