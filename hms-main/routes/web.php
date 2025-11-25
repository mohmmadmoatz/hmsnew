<?php

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
    return redirect('login');
});

Route::get('/summery', function () {
    return view('printed.summery');
})->name("summery");

Route::get('/printForm', function () {
    return view('printed.patientForm');
})->name("printedForm");

Route::get('/patinfo', function () {
    return view('printed.patinfo');
})->name("patinfo");


Route::get('/printfollow', function () {
    return view('printed.followup');
})->name("printfollow");


Route::get('/printcard', function () {
    return view('printed.card');
})->name("printcard");

Route::get('/recept', function () {
    return view('printed.recept');
})->name("printrecept");

Route::get('/doctorstatement', function () {
    return view('printed.doctorstatement');
})->name("doctorstatement");

Route::get('/doctorhelper', function () {
    return view('printed.doctorhelper');
})->name("doctorhelper");

Route::get('/m5dr', function () {
    return view('printed.m5dr');
})->name("m5dr");

Route::get('/m5drhelper', function () {
    return view('printed.m5drhelper');
})->name("m5drhelper");


Route::get('/hmsstatement', function () {
    return view('printed.hospitalstatement');
})->name("hmsstatement");

Route::get('/balance', function () {
    return view('printed.balance');
})->name("balance");

Route::get('/income', function () {
    return view('printed.income');
})->name("income");

Route::get('/incomebystage', function () {
    return view('printed.incomebystage');
})->name("incomebystage");

Route::get('/paybystage', function () {
    return view('printed.paybystage');
})->name("paybystage");

Route::get('/expbystage', function () {
    return view('printed.expfromstage');
})->name("expfromstage");

Route::get('/expense', function () {
    return view('printed.expense');
})->name("expense");


Route::get('/expandpay', function () {
    return view('printed.expandpay');
})->name("expandpay");

Route::get('/qablat', function () {
    return view('printed.qablat');
})->name("qablat");

Route::get('/doctorpays', function () {
    return view('printed.doctorpays');
})->name("doctorpays");

Route::get('/nurse', function () {
    return view('printed.nurse');
})->name("nurse");

Route::get('/ambulance', function () {
    return view('printed.ambulance');
})->name("ambulance");

Route::get('/labprint', function () {
    return view('printed.labtest');
})->name("labprint");

Route::post('/share-lab', [App\Http\Controllers\LabShareController::class, 'share'])->name('lab.share');
Route::get('/shared-lab/{token}', [App\Http\Controllers\LabShareController::class, 'show'])->name('shared.lab.show');
// Route::get('/admin/lab/statistics', App\Http\Livewire\Admin\Lab\LabStatistics::class)->name('admin.lab.statistics');


Route::get('/statistics', function () {
    return view('printed.statistics');
})->name("statistics");


Route::get('/debitaccount', function () {
    return view('printed.debitaccount');
})->name("debitaccount");

Route::get('/fixeddebit', function () {
    return view('printed.fixedDebit');
})->name("fixeddebit");


Route::get('/bankreport', function () {
    return view('printed.bank');
})->name("bankreport");

Route::get('/opreport', function () {
    return view('printed.operations');
})->name("opreport");

Route::get('/stockreport', function () {
    return view('printed.stockreport');
})->name("stockreport");


Route::get('/companyreport', function () {
    return view('printed.companyreport');
})->name("companyreport");

Route::get('/materialreport', function () {
    return view('printed.materialreport');
})->name("materialreport");

Route::get('/warehousestatement', function () {
    return view('printed.warehousestatement');
})->name("warehousestatement");

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


Route::get('/backup', [App\Http\Controllers\SettingController::class, 'backup'])->name('backup');
