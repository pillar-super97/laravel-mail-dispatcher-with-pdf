<?php

use App\Http\Controllers\Admin\InComingController;
use App\Http\Controllers\Admin\OutGoingController;
use App\Http\Controllers\Admin\FilterController;


Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    // InComing
    Route::resource('incoming', 'InComingController');
//    Route::get('/incoming', [InComingController::class, 'index']);
    Route::get('/incoming/{id}/show', [InComingController::class, 'show']);
    Route::get('/incoming/{id}/forward', [InComingController::class, 'forward']);

    // OutGoing
    Route::resource('outgoing', 'OutGoingController');
//    Route::get('/outgoing', [OutGoingController::class, 'index']);
    Route::get('/outgoing/{id}/show', [OutGoingController::class, 'show']);

    // Address
    Route::resource('address', 'AddressController');
    Route::post('/address-set', 'AddressController@set');

    // Filter
    Route::resource('filter', 'FilterController');
    Route::post('filterset', 'FilterController@set');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Asset Category
    Route::delete('asset-categories/destroy', 'AssetCategoryController@massDestroy')->name('asset-categories.massDestroy');
    Route::resource('asset-categories', 'AssetCategoryController');

    // Asset Location
    Route::delete('asset-locations/destroy', 'AssetLocationController@massDestroy')->name('asset-locations.massDestroy');
    Route::resource('asset-locations', 'AssetLocationController');

    // Asset Status
    Route::delete('asset-statuses/destroy', 'AssetStatusController@massDestroy')->name('asset-statuses.massDestroy');
    Route::resource('asset-statuses', 'AssetStatusController');

    // Asset
    Route::delete('assets/destroy', 'AssetController@massDestroy')->name('assets.massDestroy');
    Route::post('assets/media', 'AssetController@storeMedia')->name('assets.storeMedia');
    Route::post('assets/ckmedia', 'AssetController@storeCKEditorImages')->name('assets.storeCKEditorImages');
    Route::resource('assets', 'AssetController');

    // Assets History
    Route::resource('assets-histories', 'AssetsHistoryController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Integrations
    Route::delete('integrations/destroy', 'IntegrationsController@massDestroy')->name('integrations.massDestroy');
    Route::resource('integrations', 'IntegrationsController');

    // Platform
    Route::delete('platforms/destroy', 'PlatformController@massDestroy')->name('platforms.massDestroy');
    Route::resource('platforms', 'PlatformController');

    // Fortnox
    Route::delete('fortnoxes/destroy', 'FortnoxController@massDestroy')->name('fortnoxes.massDestroy');
    Route::resource('fortnoxes', 'FortnoxController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
