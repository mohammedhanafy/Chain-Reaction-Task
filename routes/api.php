<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ContactInformationController;


Route::group(['prefix' => 'auth'], function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    
});

Route::group(['middleware' => 'auth:api'], function () {

    Route::group(['middleware' => 'AuthPerson:employee', 'prefix' => 'employee'], function () {
        Route::post('/updateContactInformation', [ContactInformationController::class, 'updateContactInformation']);
    });

    Route::group(['middleware' => 'AuthPerson:manager', 'prefix' => 'employees'], function () {
        Route::get('/', [EmployeeController::class, 'index']);
        Route::post('/store', [EmployeeController::class, 'store']);
        Route::get('/deactivate/{user}', [EmployeeController::class, 'deactivate']);
    });

});
