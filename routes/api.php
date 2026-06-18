<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleProduitController;
use App\Http\Controllers\MateriauController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 1. Routes publiques (Ouvertes aux visiteurs)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route publique — Catalogue des modules (accessible sans token)
Route::get('/modules', [ModuleProduitController::class, 'index']);
Route::get('/modules/{id}', [ModuleProduitController::class, 'show']);

// 2. Routes sécurisées de l'application (Nécessitent un Token JWT valide)
Route::middleware('auth:api')->group(function () { 

    // Espace réservé uniquement aux Administrateurs
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function() {
            return response()->json(['message' => 'Espace Secrétariat / Admin']);
        });

        // CRUD Modules Produits
        Route::get('/admin/modules',         [ModuleProduitController::class, 'index']);
        Route::post('/admin/modules',        [ModuleProduitController::class, 'store']);
        Route::get('/admin/modules/{id}',    [ModuleProduitController::class, 'show']);
        Route::put('/admin/modules/{id}',    [ModuleProduitController::class, 'update']);
        Route::delete('/admin/modules/{id}', [ModuleProduitController::class, 'destroy']);

        // CRUD Matériaux
        Route::get('/admin/materiaux',         [MateriauController::class, 'index']);
        Route::post('/admin/materiaux',        [MateriauController::class, 'store']);
        Route::get('/admin/materiaux/{id}',    [MateriauController::class, 'show']);
        Route::put('/admin/materiaux/{id}',    [MateriauController::class, 'update']);
        Route::delete('/admin/materiaux/{id}', [MateriauController::class, 'destroy']);
    });

    // Espace accessible aux Commerciaux ET aux Admins
    Route::middleware('role:commercial,admin')->group(function () {
        Route::get('/commercial/devis', function() {
            return response()->json(['message' => 'Gestion des paniers et devis clients']);
        });
    });

    // Espace accessible aux Clients
    Route::middleware('role:client')->group(function () {
        Route::get('/client/cuisine', function() {
            return response()->json(['message' => 'Suivi de la conception de ma cuisine']);
        });
    });
    
});