<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('autores', AuthorController::class);

Route::apiResource('assuntos', SubjectController::class);
