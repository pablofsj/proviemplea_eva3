<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EmpresaCandidatoController;
use App\Http\Controllers\HealthCheckController;

Route::get('/health', [HealthCheckController::class, 'index']);

Route::apiResource('candidatos', CandidatoController::class);
Route::patch('candidatos/{id}/estado', [CandidatoController::class, 'cambiarEstado']);

Route::apiResource('empresas', EmpresaController::class);
Route::patch('empresas/{id}/estado', [EmpresaController::class, 'cambiarEstado']);

Route::apiResource('empresa-candidatos', EmpresaCandidatoController::class);
