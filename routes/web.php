<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
// use App\Livewire\Admin\Products;
// use App\Livewire\Admin\Categories;
use App\Livewire\Home;
use App\Livewire\Cartlist;
use App\Livewire\Admin\Orders;
use App\Livewire\Admin\Users;
use App\Livewire\Help;
use App\Livewire\Success;

use App\Livewire\Admin\Settings\Profile as AdminProfile;
use App\Livewire\Admin\Settings\Password as AdminPassword;
use App\Livewire\Admin\Settings\Appearance as AdminAppearance;

use App\Livewire\Productlist;
use App\Livewire\Productdetail;
// use App\Livewire\Admin\Subcategory;

Route::get('/', Home::class)->name('home');
Route::get('/help', Help::class)->name('help');
Route::get('/products', Productlist::class)->name('products');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/cart', Cartlist::class)->name('cart');
    Route::get('/checkout/success', Success::class)->name('checkout.success');
     
});

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', Dashboard::class)->name('admin.dashboard');
    // Route::get('/admin/product', Products::class)->name('admin.products');
   
   Route::get('/admin/products', \App\Livewire\Admin\Products\Index::class)->name('admin.products.index');
   Route::get('/admin/products/create', \App\Livewire\Admin\Products\Create::class)->name('admin.products.create');
    Route::get('/admin/orders', Orders::class)->name('admin.orders');
    Route::get('/admin/users', Users::class)->name('admin.users');
      Route::get('/admin/category', \App\Livewire\Admin\Categories::class)->name('admin.categories');

      Route::get('/admin/category/{categoryPath?}', \App\Livewire\Admin\Subcategory::class)
        ->where('categoryPath', '.*')
           ->name('admin.category.subcategory'); 
   
    Route::redirect('admin/settings', 'admin/settings/profile');

    Route::get('/admin/settings/profile', AdminProfile::class)->name('admin.settings.profile');
    Route::get('/admin/settings/password', AdminPassword::class)->name('admin.settings.password');
    Route::get('/admin/settings/appearance', AdminAppearance::class)->name('admin.settings.appearance');


});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
Route::get('/{product:slug}', Productdetail::class)->name('product.show');
//TODO: H
