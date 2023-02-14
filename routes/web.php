<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
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

Route::get('Employee',[EmployeeController::class, 'index']);
Route::post('Employee',[EmployeeController::class, 'store'])->name("store_data");
Route::get('/fetch-employee',[EmployeeController::class, 'fetch_employee'])->name("fetch");
Route::get('/edit-employee/{id}',[EmployeeController::class, 'edit_employee'])->name("edit");
Route::post('/update-employee/{id}',[EmployeeController::class, 'update'])->name("update");
