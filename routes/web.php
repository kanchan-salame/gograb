<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\GoodTypeController;
use App\Http\Controllers\PackageSizeController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceSubCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductSubCategoryController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FoodOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Events\SendNotification;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

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

    Route::resource('cart', CartController::class);
    Route::resource('foodOrder', FoodOrderController::class);

    Route::resource('users', UsersController::class);
    Route::get('myOrders', [UsersController::class, 'myOrders'])->name('user.myOrders');
    Route::resource('serviceCategory', ServiceCategoryController::class);
    Route::resource('serviceSubCategory', ServiceSubCategoryController::class);
    Route::resource('service', ServiceController::class);

    Route::resource('productCategory', ProductCategoryController::class);
    Route::resource('productSubCategory', ProductSubCategoryController::class);
    Route::resource('product', ProductController::class);


    Route::resource('subService', SubServiceController::class);
    Route::resource('goodType', GoodTypeController::class);
    Route::resource('packageSize', PackageSizeController::class);
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
    Route::get('edit-restaurant-menu-item/{restaurantMenu}/{restaurantMenuItem}', [RestaurantController::class, 'editMenuItem'])->name('restaurant.menu.edit.item');
    Route::put('restaurant-update-menu-item/{restaurantMenu}/{restaurantMenuItem}', [RestaurantController::class, 'updateMenuItem'])->name('restaurant.update.menu.item');
    Route::get('restaurant-destroy-menu-item/{restaurantMenu}/{restaurantMenuItem}', [RestaurantController::class, 'destroyMenuItem'])->name('restaurant.destroy.menu.item');
    Route::post('restaurant-update-categories/{restaurant}', [RestaurantController::class, 'updateCategories'])->name('restaurant.update.categories');
    Route::post('restaurant-update-timing/{restaurant}', [RestaurantController::class, 'updateTiming'])->name('restaurant.update.timing');

    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
    Route::post('/notification-send', [NotificationController::class, 'sendNotification'])->name('notification.sent');
    Route::get('/unreadNotification', [NotificationController::class, 'unreadNotification'])->name('notification.unread');
    Route::get('/markAllAsRead', [NotificationController::class, 'markAllAsRead'])->name('notification.read');
    Route::post('/showNotification/{id}', [NotificationController::class, 'showNotification'])->name('notification.show');



});
