<?php

use App\Http\Controllers\BattalionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\UserAllowDepController;
use App\Http\Controllers\UserlistController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SoldierController;
use App\Http\Controllers\TambonController;


use App\Models\Department;
use App\Models\Service;
use App\Models\User;
use App\Models\UserAllowDep;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {


        $Department=Department::select('dep_id')
        //->selectRaw('ใส่sql ตรงๆเลย')
        ->selectRaw('min(departments.dep_index)dep_index')
        ->selectRaw('min(department_name)department_name')
        ->selectRaw("SUM(CASE WHEN soldier_dep_id != '' THEN 1 ELSE 0 END) AS total")
        //->leftJoin("เทเบิ้ลที่จะเอามาเชื่อม", "soldiers.ฟิวที่ตรงกัน", "=", "departments.ฟิวตรงกัน")
        ->leftJoin("soldiers", "soldiers.soldier_dep_id", "=", "departments.dep_id")
        //->where('soldier_dep_id','!=',)
        ->groupBy('dep_id')
        ->orderBy('dep_index')
        //->dd()
        ->get();

        return view('dashboard',compact('Department'));
    })->name('dashboard');
    Route::get('/department/all',[DepartmentController::class,'index'])->name('department');
    Route::post('/department/add',[DepartmentController::class,'store'])->name('addDepartment');
    Route::get('/department/edit/{id}',[DepartmentController::class,'edit']);
    Route::post('/department/update/{id}',[DepartmentController::class,'update']);

    Route::get('/department/softdelete/{id}',[DepartmentController::class,'softdelete']);
    Route::get('/department/restore/{id}',[DepartmentController::class,'restore']);
    Route::get('/department/delete/{id}',[DepartmentController::class,'delete']);

    //sevice
    Route::get('/service/all',[ServiceController::class,'index'])->name('service');
    Route::post('/service/add',[ServiceController::class,'store'])->name('addService');
    Route::get('/service/edit/{id}',[ServiceController::class,'edit']);
    Route::post('/service/update/{id}',[ServiceController::class,'update']);
    Route::get('/service/delete/{id}',[ServiceController::class,'delete']);

    //*****soldier
    Route::match(['get', 'post'], '/soldier/all',[SoldierController::class,'index'])->name('soldier');
    //Route::match(['get', 'post'], '/soldier/add',[SoldierController::class,'index'])->name('soldier');
    Route::post('/soldier/add',[SoldierController::class,'store'])->name('addSoldier');
    Route::get('/soldier/edit/{id}',[SoldierController::class,'edit']);
        //gotoadd
    Route::get('/soldier/startadd/',[SoldierController::class,'startadd'])->name('startadd');
    Route::post('/soldier/update/{id}',[SoldierController::class,'update']);
    Route::get('/soldier/delete/{id}',[SoldierController::class,'delete']);


     //battalion
    Route::get('/battalion/all',[BattalionController::class,'index'])->name('battalion');
    Route::post('/battalion/add',[BattalionController::class,'store'])->name('addBattalion');
    //
    Route::get('/userallow/edit/{id}',[UserAllowDepController::class,'edit']);

    ///userlist
    Route::get('/userlist/all',[UserlistController::class,'index'])->name('userlist.index');
    Route::post('/userlist/add',[UserlistController::class,'store'])->name('userlist.store');
    Route::get('/userlist/edit/{id}',[UserlistController::class,'edit'])->name('userlist.edit');
    Route::get('/userlist/dep/{id}',[UserlistController::class,'dep'])->name('userlist.dep');
    Route::get('/userlist/delete/{id}',[UserlistController::class,'delete'])->name('userlist.delete');

    ///excel
    Route::get('/soldier/excel', [ExcelController::class,'index']);
    Route::post('/soldier/excel/import', [ExcelController::class,'import']);
    Route::get('/soldier/excel/export', [ExcelController::class,'export']);


    Route::get('/soldier/provinces',[TambonController::class,'getProvinces']);
    Route::get('/soldier/amphoes',[TambonController::class,'getAmphoes']);
    // Route::get('/soldier/tambons',[TambonController::class,'getTambons']);
    // Route::get('/soldier/zipcodes',[TambonController::class,'getZipcodes']);

});


