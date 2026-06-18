<?php
// Auth routes - will be fully scaffolded by Breeze
// Placeholder to prevent route loading errors
use Illuminate\Support\Facades\Route;

Route::get('login', fn() => redirect('/'))->name('login');
Route::get('register', fn() => redirect('/'))->name('register');
Route::post('logout', fn() => redirect('/'))->name('logout');
