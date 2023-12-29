<?php

use App\Http\Controllers\apptokenController;
use App\Http\Controllers\attachmentController;
use App\Http\Controllers\documentController;
use App\Http\Controllers\maincategoryController;
use App\Http\Controllers\messageController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\postController;
use App\Http\Controllers\pricingController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\profilesubcategoryController;
use App\Http\Controllers\projectFilesController;
use App\Http\Controllers\rateController;
use App\Http\Controllers\roomController;
use App\Http\Controllers\sellerController;
use App\Http\Controllers\servicetypeController;
use App\Http\Controllers\subcategoryController;
use App\Http\Controllers\userController;
use App\Http\Controllers\workstationController;
use App\Models\pricingModel;
use App\Models\servicetypeModel;
use App\Models\subcategoryModel;
use App\Models\workstationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::group(['middleware' => 'auth:sanctum'], function () {
Route::post('addServiceType', [servicetypeController::class, 'addServiceType']);
Route::get('getServiceTypes', [servicetypeController::class, 'getServiceTypes']);
Route::post('updateServiceType', [servicetypeController::class, 'updateServiceType']);
Route::post('deleteServiceType', [servicetypeController::class, 'deleteServiceType']);


Route::get('getMainCategories', [maincategoryController::class, 'getMainCategories']);
Route::post('addMainCategory', [maincategoryController::class, 'addMainCategory']);
Route::post('updateMainCategory', [maincategoryController::class, 'updateMainCategory']);
Route::post('deleteMainCategory', [maincategoryController::class, 'deleteMainCategory']);


Route::get('getsubCategories', [subcategoryController::class, 'getsubCategories']);
Route::post('addsubCategory', [subcategoryController::class, 'addsubCategory']);
Route::post('updatesubCategory', [subcategoryController::class, 'updatesubCategory']);
Route::post('deletesubCategory', [subcategoryController::class, 'deletesubCategory']);
Route::get('categorySearch/{string}', [subcategoryController::class, 'categorySearch']);



Route::post('updateProfile', [profileController::class, 'updateProfile']);
Route::get('getImage/{profileid}', [profileController::class, 'getImage']);
Route::post('addProfile', [profileController::class, 'addProfile']);
Route::get('getProfile/{userid}', [profileController::class, 'getProfile']);


Route::get('getPosts/{profileid}', [postController::class, 'getPosts']);
Route::post('addPost', [postController::class, 'addPost']);
Route::post('updatePost', [postController::class, 'updatePost']);
Route::get('getallPosts/{profileid}', [postController::class, 'getallPosts']);
Route::post('deletePost', [postController::class, 'deletePost']);



Route::get('getWorkstations/{profileid}', [workstationController::class, 'getWorkstations']);
Route::post('addWorkstation', [workstationController::class, 'addWorkstation']);
Route::post('updateWorkstation', [workstationController::class, 'updateWorkstation']);
Route::post('deleteWorkstation', [workstationController::class, 'deleteWorkstation']);


Route::get('getPricing/{profileid}', [pricingController::class, 'getPricing']);
Route::post('addPricing', [pricingController::class, 'addPricing']);
Route::post('updatePricing', [pricingController::class, 'updatePricing']);
Route::get('getallPricing', [pricingController::class, 'getallPricing']);


Route::post('addRate', [rateController::class, 'addRate']);
Route::get('getRates/{profileid}', [rateController::class, 'getRates']);


Route::post('addOrder', [orderController::class, 'addOrder']);
Route::post('updateOrder', [orderController::class, 'updateOrder']);
Route::post('updatevOrder', [orderController::class, 'updateOrder']);
Route::get('getOrders/{userid}', [orderController::class, 'getOrders']);
Route::post('checkOrder', [orderController::class, 'checkOrder']);
Route::post('deleteOrder', [orderController::class, 'deleteOrder']);



Route::get('getDocument/{orderid}', [documentController::class, 'getDocument']);
Route::post('addDocument', [documentController::class, 'addDocument']);
Route::post('updateDocument', [documentController::class, 'updateDocument']);
Route::post('checkDocument', [documentController::class, 'checkDocument']);
Route::post('deleteDocument', [documentController::class, 'deleteDocument']);

Route::get('getAttach/{docid}', [attachmentController::class, 'getAttach']);

Route::post('createRoom', [roomController::class, 'createRoom']);
Route::get('getRooms/{userid}', [roomController::class, 'getRooms']);


Route::post('addMessage', [messageController::class, 'addMessage']);
Route::post('updateMessage', [messageController::class, 'updateMessage']);
Route::post('deleteMessage', [messageController::class, 'deleteMessage']);
Route::get('getMessages/{userid}', [messageController::class, 'getMessages']);

Route::post('addAppToken', [apptokenController::class, 'addAppToken']);
Route::post('deleteToken', [apptokenController::class, 'deleteToken']);

Route::post('addFile', [projectFilesController::class, 'addFile']);
Route::post('updateFile', [projectFilesController::class, 'updateFile']);



// });



Route::get('userSearch/{string}', [userController::class, 'userSearch']);
Route::get('getUsers', [userController::class, 'getUsers']);
Route::post('signUp', [userController::class, 'signUp']);
Route::post('upgradeUser', [userController::class, 'upgradeUser']);
Route::post('addUser', [userController::class, 'addUser']);
Route::post('blockUser', [userController::class, 'blockUser']);
Route::post('signIn', [userController::class, 'signIn']);
