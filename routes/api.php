<?php

use App\Http\Controllers\CoachController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//rutas del coach
Route::get('/getCoaches', [CoachController::class, 'index']);
Route::post('/registrarCoach', [CoachController::class, 'store']);
Route::get('/getCoach/{id}', [CoachController::class, 'getCoachById']);
Route::put('/actualizarCoach/{id}', [CoachController::class, 'update']);
Route::put('/deshabilitarCoach/{id}', [CoachController::class, 'deshabilitar']);

#seccion para bootcamps por coach
Route::get('/bootcamps', [CoachController::class, 'obtenerBootcamps']);
Route::post('/asignacionBootcamps/{id_coach}', [CoachController::class, 'asignarBootcampsByCoach']);

Route::post('/listaBootcampsCoach', [CoachController::class, 'obtenerBootcampsByCoach']);