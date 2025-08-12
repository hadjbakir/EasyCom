<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

// Serve files from the public storage disk via Laravel, bypassing static /storage serving
Route::get('/media/{path}', function (string $path) {
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return Storage::disk('public')->response($path);
})->where('path', '.*');


