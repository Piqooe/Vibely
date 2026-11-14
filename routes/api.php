<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SongController;
use Illuminate\Support\Facades\Route;

// Authentication (Sanctum)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Songs & Player
Route::get('/songs/{song}', [SongController::class, 'show']);
Route::post('/songs/{song}/play', [SongController::class, 'play']);
Route::post('/songs/{song}/like', [SongController::class, 'toggleLike']);

// Playlists
Route::get('/playlists', [PlaylistController::class, 'index']);
Route::post('/playlists', [PlaylistController::class, 'store']);
Route::get('/playlists/{playlist:slug}', [PlaylistController::class, 'show']);
Route::post('/playlists/{playlist}/songs', [PlaylistController::class, 'addSong']);
Route::delete('/playlists/{playlist}/songs/{song}', [PlaylistController::class, 'removeSong']);

// Live Search
Route::get('/search', [SearchController::class, 'index']);