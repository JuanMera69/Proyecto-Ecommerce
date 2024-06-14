<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

// Rutas públicas
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/', [CategoryController::class, 'index'])->name('home');

Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/search', [ProductController::class, 'search'])->name('products.search');

Route::get('categories/{category}/products', [CategoryController::class, 'showProducts'])->name('categories.showProducts');
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');


Route::middleware(['auth'])->group(function () {

    // Rutas de tipo resource para el usuario, producto y categoria
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    // Rutas para crear y guardar un usuario
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');

    // Rutas para el perfil del usuario
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Rutas para el carrito de compras
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');

});

// Rutas de autenticación
Auth::routes(['home' => false]);

// Ruta /home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
