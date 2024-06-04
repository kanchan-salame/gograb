<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RestaurantController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::resource('users', UsersController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('restaurant', RestaurantController::class);
    Route::get('restaurant-categories/{restaurant}', [RestaurantController::class, 'selectCategories'])->name('restaurant.categories');
    Route::get('restaurant-timing/{restaurant}', [RestaurantController::class, 'setTiming'])->name('restaurant.timing');
    Route::get('restaurant-menus/{restaurant}', [RestaurantController::class, 'setMenus'])->name('restaurant.menus');
    Route::get('create-restaurant-menu/{restaurant}/', [RestaurantController::class, 'createMenu'])->name('restaurant.menu.create');
    Route::get('edit-restaurant-menu/{restaurant}/{restaurantMenu}', [RestaurantController::class, 'editMenu'])->name('restaurant.menu.edit');
    Route::post('restaurant-save-menu/{restaurant}/', [RestaurantController::class, 'saveMenu'])->name('restaurant.save.menu');
    Route::put('restaurant-update-menu/{restaurant}/{restaurantMenu}', [RestaurantController::class, 'updateMenu'])->name('restaurant.update.menu');
    Route::get('restaurant-destroy-menu/{restaurant}/{restaurantMenu}', [RestaurantController::class, 'destroyMenu'])->name('restaurant.destroy.menu');
    Route::get('restaurant-create-menu-item/{restaurantMenu}', [RestaurantController::class, 'createMenuItem'])->name('restaurant.create.menu.item');
    Route::post('restaurant-save-menu-item/{restaurantMenu}/', [RestaurantController::class, 'storeMenuItem'])->name('restaurant.store.menu.item');
    Route::get('edit-restaurant-menu/{restaurantMenu}/{restaurantMenuItem}', [RestaurantController::class, 'editMenuItem'])->name('restaurant.menu.edit');
    Route::put('restaurant-update-menu-item/{restaurantMenu}/{restaurantMenuItem}', [RestaurantController::class, 'updateMenuItem'])->name('restaurant.update.menu.item');
    Route::get('restaurant-destroy-menu-item/{restaurantMenu}/{restaurantMenuItem}', [RestaurantController::class, 'destroyMenuItem'])->name('restaurant.destroy.menu.item');
    Route::post('restaurant-update-categories/{restaurant}', [RestaurantController::class, 'updateCategories'])->name('restaurant.update.categories');
    Route::post('restaurant-update-timing/{restaurant}', [RestaurantController::class, 'updateTiming'])->name('restaurant.update.timing');
});
