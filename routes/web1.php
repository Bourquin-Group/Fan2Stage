<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('stripe_webhooks', 'App\Http\Controllers\WebhookController@webhook');

Route::get('apple-token', 'App\Http\Controllers\AppleController@getAppletoken')->name('getWebAppletoken');


Route::get('/apple-login', function () {
    return view('applelogin');
})->middleware('apple_sso');

Route::get('/', function () {
    return view('auth.login');
});
Route::get('auth/{service}', 'App\Http\Controllers\SocialController@redirect');


Route::match(['get', 'post'], 'auth/{service}/callback', 'App\Http\Controllers\SocialController@callback');


Route::get('stripe','App\Http\Controllers\StripePaymentController@stripe');
Route::post('stripe', 'App\Http\Controllers\StripePaymentController@stripePost')->name('stripe.post');
// admin routes
Route::get('admin', 'App\Http\Controllers\Admin\AuthController@loginForm')->name('adminLoginForm');
Route::post('admin/login', 'App\Http\Controllers\Admin\AuthController@login')->name('admin-login');
   
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function ()
{
    //Auth::routes();
    Route::post('logout', 'App\Http\Controllers\Admin\AuthController@logout')->name('admin-logout');
    Route::group(['middleware' => ['auth', 'isadmin']], function ()
    {
        Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'adminIndex'])->name('admin-home');
        // User Management
         Route::get('user', [App\Http\Controllers\Admin\UserManagementController::class, 'user'])->name('user');
        Route::get('user/add', [App\Http\Controllers\Admin\UserManagementController::class, 'usercreation'])->name('user.add');
        Route::post('userstore', [App\Http\Controllers\Admin\UserManagementController::class, 'userstore'])->name('userstore');
        Route::get('useredit/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'edituser'])->name('edit.user');
        Route::post('updateuser/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'updateuser'])->name('update.user');
        Route::get('deleteuser/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'deleteuser']);

        Route::get('artist', [App\Http\Controllers\Admin\UserManagementController::class, 'artist'])->name('artist');
        Route::get('artist/add', [App\Http\Controllers\Admin\UserManagementController::class, 'artistcreation'])->name('artist.add');
        Route::post('artiststore', [App\Http\Controllers\Admin\UserManagementController::class, 'artiststore'])->name('artiststore');
        Route::get('artistedit/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'editartist'])->name('edit.artist');
        Route::post('updateartist/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'updateartist'])->name('update.artist');
        Route::get('deleteartist/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'deleteartist']);
        // User Management

        //CMS Management
        Route::get('cms', [App\Http\Controllers\Admin\CmsManageController::class, 'cms'])->name('cms');
        Route::get('cms/add', [App\Http\Controllers\Admin\CmsManageController::class, 'cmscreation'])->name('cms.add');
        Route::post('cmsstore', [App\Http\Controllers\Admin\CmsManageController::class, 'cmsstore'])->name('cmsstore');
        Route::get('cmsedit/{id}', [App\Http\Controllers\Admin\CmsManageController::class, 'editcms'])->name('edit.cms');
        Route::post('updatecms/{id}', [App\Http\Controllers\Admin\CmsManageController::class, 'updatecms'])->name('update.cms');
        Route::get('deletecms/{id}', [App\Http\Controllers\Admin\CmsManageController::class, 'deletecms']);
         //CMS Management

         //Introductory Management
        Route::get('introductory', [App\Http\Controllers\Admin\IntroductoryController::class, 'introductory'])->name('introductory');
        Route::get('introductory/add', [App\Http\Controllers\Admin\IntroductoryController::class, 'introductorycreation'])->name('introductory.add');
        Route::post('introductorystore', [App\Http\Controllers\Admin\IntroductoryController::class, 'introductorystore'])->name('introductorystore');
        Route::get('introductoryedit/{id}', [App\Http\Controllers\Admin\IntroductoryController::class, 'editintroductory'])->name('edit.introductory');
        Route::post('updateintroductory/{id}', [App\Http\Controllers\Admin\IntroductoryController::class, 'updateintroductory'])->name('update.introductory');
        Route::get('deleteintroductory/{id}', [App\Http\Controllers\Admin\IntroductoryController::class, 'deleteintroductory']);
         //Introductory Management

        //Setting Management
        Route::get('setting', [App\Http\Controllers\Admin\SettingController::class, 'setting'])->name('setting');
        Route::get('setting/add', [App\Http\Controllers\Admin\SettingController::class, 'settingcreation'])->name('setting.add');
        Route::post('settingstore', [App\Http\Controllers\Admin\SettingController::class, 'settingstore'])->name('settingstore');
        Route::get('settingedit/{id}', [App\Http\Controllers\Admin\SettingController::class, 'editsetting'])->name('edit.setting');
        Route::post('updatesetting/{id}', [App\Http\Controllers\Admin\SettingController::class, 'updatesetting'])->name('update.setting');
        // Route::get('deletecms/{id}', [App\Http\Controllers\Admin\SettingController::class, 'deletecms']);
         //Setting Management

        //Admin Profile Management
        Route::get('profileedit/{id}', [App\Http\Controllers\Admin\ProfileManageController::class, 'editprofile'])->name('edit.profile');
        Route::post('updateprofile/{id}', [App\Http\Controllers\Admin\ProfileManageController::class, 'updateprofile'])->name('update.profile');
         //Admin Profile Management

          //Change Password Management
        Route::get('passwordedit/{id}', [App\Http\Controllers\Admin\ProfileManageController::class, 'editpassword'])->name('edit.password');
        Route::post('updatepassword/{id}', [App\Http\Controllers\Admin\ProfileManageController::class, 'updatepassword'])->name('update.password');
         //Change Password Management

         //SubscriptionPlan Management
        Route::get('subscriptionplan', [App\Http\Controllers\Admin\SubscriptionPlanController::class, 'subscriptionplan'])->name('subscriptionplan');
        Route::get('subscriptionplan/add', [App\Http\Controllers\Admin\SubscriptionPlanController::class, 'subscriptionplancreation'])->name('subscriptionplan.add');
        Route::post('subscriptionplanstore', [App\Http\Controllers\Admin\SubscriptionPlanController::class, 'subscriptionplanstore'])->name('subscriptionplanstore');
        Route::get('subscriptionplanedit/{id}', [App\Http\Controllers\Admin\SubscriptionPlanController::class, 'editsubscriptionplan'])->name('edit.subscriptionplan');
        Route::post('updatesubscriptionplan/{id}', [App\Http\Controllers\Admin\SubscriptionPlanController::class, 'updatesubscriptionplan'])->name('update.subscriptionplan');
        // Route::get('deletecms/{id}', [App\Http\Controllers\Admin\SettingController::class, 'deletecms']);
         //SubscriptionPlan Management
    });

     

    //Auth::routes();
});



Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'users'],function () {
    Route::group(['middleware' => ['auth', 'user']], function ()
    {
        Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'adminIndex'])->name('user-home');
    });
    
    });

    Route::group(['prefix' => 'web'], function ()
    {
        Route::get('aboutUs', [App\Http\Controllers\Web\SettingController::class, 'aboutUs'])->name('aboutUs');
        Route::get('introductory', [App\Http\Controllers\Web\IntroductoryscreenController::class, 'introductory'])->name('introductory');

        // Artist Home Page
        Route::get('artisthome', [App\Http\Controllers\Web\HomepageController::class, 'homepage'])->name('artisthome');
        // Artist Home Page

        // Artist Live Event
        Route::get('liveevent', [App\Http\Controllers\Web\HomepageController::class, 'liveevent'])->name('liveevent');
        // Artist Live Event
        
        // Artist Subscription
        Route::get('mainContent/subscription', [App\Http\Controllers\Web\MainController::class, 'mainContent'])->name('mainContent.subscription');
        // Artist Subscription
    });
