<?php

	use App\Http\Controllers\API\APISupplierController;
	use App\Http\Controllers\API\MedicineController;
	use App\Http\Controllers\APIAuth\AuthController;
	use App\Http\Controllers\NewPurchaseController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//This is from APIAuth/AuthController for API login
		Route::post('/login', [AuthController::class, 'login']);
		Route::group(['middleware'=>['auth:sanctum','protect']],function (){
		Route::resource('supplier',APISupplierController::class);
		Route::resource('medicine_category',MedicineController::class);


	});


	Route::group(['middleware'=>['auth:sanctum','protect_medicine']],function(){
		Route::get('medicine_list',[MedicineController::class,'medicineList']);
		Route::get('new_purchase', [NewPurchaseController::class, 'create_purchase']);

	});