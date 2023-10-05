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
Route::get('/clear-cache', function() {
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('view:clear');
	$exitCode = Artisan::call('optimize:clear');
	$exitCode = Artisan::call('config:clear');
	$exitCode = Artisan::call('route:clear');
});
Route::get('stripe_webhooks', 'App\Http\Controllers\WebhookController@webhook');

Route::get('getAppletoken', 'App\Http\Controllers\AppleController@getAppletoken')->name('getAppletoken');


Route::get('/apple-login', function () {
    return view('applelogin');
})->middleware('apple_sso');


Route::get('auth/{service}', 'App\Http\Controllers\FanSocialController@redirect');


Route::match(['get', 'post'], 'auth/{service}/callback', 'App\Http\Controllers\FanSocialController@callback');


Route::get('stripe','App\Http\Controllers\StripePaymentController@stripe');
Route::post('stripe', 'App\Http\Controllers\StripePaymentController@stripePost')->name('stripe.post');
// admin routes
Route::get('admin', 'App\Http\Controllers\Admin\AuthController@loginForm')->name('adminLoginForm');
Route::get('admin/login', 'App\Http\Controllers\Admin\AuthController@loginForm')->name('adminLoginForm');
Route::post('admin/login', 'App\Http\Controllers\Admin\AuthController@login')->name('admin-login');
   
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function ()
{
    //Auth::routes();
    Route::post('logout', 'App\Http\Controllers\Admin\AuthController@logout')->name('admin-logout');
    Route::group(['middleware' => ['auth', 'isadmin']], function ()
    {
        Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'adminIndex'])->name('admin-home');
        // Route::get('eventlist', [App\Http\Controllers\HomeController::class, 'eventlist'])->name('eventlist');
        // Route::get('artistlist', [App\Http\Controllers\HomeController::class, 'artistlist'])->name('artistlist');
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

        //Contact Management
        Route::get('contactcms', [App\Http\Controllers\Admin\ContactManageController::class, 'contactcms'])->name('contactcms');
        // Route::get('contact/add', [App\Http\Controllers\Admin\ContactManageController::class, 'Contactcreation'])->name('contact.add');
        // Route::post('contactstore', [App\Http\Controllers\Admin\ContactManageController::class, 'Contactstore'])->name('contactstore');
        Route::get('contactedit/{id}', [App\Http\Controllers\Admin\ContactManageController::class, 'editContact'])->name('edit.contact');
        Route::post('updatecontact/{id}', [App\Http\Controllers\Admin\ContactManageController::class, 'updateContact'])->name('update.contact');
        // Route::get('deletecontact/{id}', [App\Http\Controllers\Admin\ContactManageController::class, 'deleteContact']);
         //Contact Management

         //Introductory Management
        Route::get('introductory', [App\Http\Controllers\Admin\IntroductoryController::class, 'introductory'])->name('introductory');
        Route::get('introductory/add', [App\Http\Controllers\Admin\IntroductoryController::class, 'introductorycreation'])->name('introductory.add');
        Route::post('introductorystore', [App\Http\Controllers\Admin\IntroductoryController::class, 'introductorystore'])->name('introductorystore');
        Route::get('introductoryedit/{id}', [App\Http\Controllers\Admin\IntroductoryController::class, 'editintroductory'])->name('edit.introductory');
        Route::post('updateintroductory/{id}', [App\Http\Controllers\Admin\IntroductoryController::class, 'updateintroductory'])->name('update.introductory');
        Route::get('deleteintroductory/{id}', [App\Http\Controllers\Admin\IntroductoryController::class, 'deleteintroductory']);
         //Introductory Management

         //Audio Management
        Route::get('audio', [App\Http\Controllers\Admin\AudioController::class, 'audio'])->name('audio');
        Route::get('audio/add', [App\Http\Controllers\Admin\AudioController::class, 'audiocreation'])->name('audio.add');
        Route::post('audiostore', [App\Http\Controllers\Admin\AudioController::class, 'audiostore'])->name('audiostore');
        Route::get('audioedit/{id}', [App\Http\Controllers\Admin\AudioController::class, 'editaudio'])->name('edit.audio');
        Route::post('updateaudio/{id}', [App\Http\Controllers\Admin\AudioController::class, 'updateaudio'])->name('update.audio');
        Route::get('deleteaudio/{id}', [App\Http\Controllers\Admin\AudioController::class, 'deleteaudio']);
         //Audio Management

         //Buffer Management
        Route::get('buffer', [App\Http\Controllers\Admin\BufferController::class, 'buffer'])->name('buffer');
        Route::get('buffer/add', [App\Http\Controllers\Admin\BufferController::class, 'buffercreation'])->name('buffer.add');
        Route::post('bufferstore', [App\Http\Controllers\Admin\BufferController::class, 'bufferstore'])->name('bufferstore');
        Route::get('bufferedit/{id}', [App\Http\Controllers\Admin\BufferController::class, 'editbuffer'])->name('edit.buffer');
        Route::post('updatebuffer/{id}', [App\Http\Controllers\Admin\BufferController::class, 'updatebuffer'])->name('update.buffer');
        Route::get('deletebuffer/{id}', [App\Http\Controllers\Admin\BufferController::class, 'deletebuffer']);
         //Buffer Management

         //Action Management
        Route::get('action', [App\Http\Controllers\Admin\ActionController::class, 'action'])->name('action');
        Route::get('action/add', [App\Http\Controllers\Admin\ActionController::class, 'actioncreation'])->name('action.add');
        Route::post('actionstore', [App\Http\Controllers\Admin\ActionController::class, 'actionstore'])->name('actionstore');
        Route::get('actionedit/{id}', [App\Http\Controllers\Admin\ActionController::class, 'editaction'])->name('edit.action');
        Route::post('updateaction/{id}', [App\Http\Controllers\Admin\ActionController::class, 'updateaction'])->name('update.action');
        Route::get('deleteaction/{id}', [App\Http\Controllers\Admin\ActionController::class, 'deleteaction']);
         //Action Management

         //Event Management
        Route::get('event', [App\Http\Controllers\Admin\EventController::class, 'event'])->name('event');
        Route::get('event/add', [App\Http\Controllers\Admin\EventController::class, 'eventcreation'])->name('event.add');
        Route::post('eventStores', [App\Http\Controllers\Admin\EventController::class, 'eventstore'])->name('eventStores');
        Route::get('eventedit/{id}', [App\Http\Controllers\Admin\EventController::class, 'editevent'])->name('eventedit');
        Route::post('updateevent/{id}', [App\Http\Controllers\Admin\EventController::class, 'updateevent'])->name('updateevent');
        Route::get('deleteevent/{id}', [App\Http\Controllers\Admin\EventController::class, 'deleteevent']);
        //Event Management

        // Payment Management
        Route::get('payment', [App\Http\Controllers\Admin\PaymentController::class, 'payment'])->name('payment');
        // Payment Management

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
        Route::group(['middleware' => ['auth', 'user']], function ()
        {
            Route::group(['middleware' => ['subscription']], function ()
            {
                    Route::group(['middleware' => ['artistprofile']], function ()
                {
            // Artist Home Page
            Route::get('artisthome', [App\Http\Controllers\Web\HomepageController::class, 'homepage'])->name('artisthome');
            Route::get('timezone', [App\Http\Controllers\Web\HomepageController::class, 'timezone'])->name('timezone');
            // Artist Home Page

            // Artist Live Event
            Route::get('liveevent', [App\Http\Controllers\Web\ArtistController::class, 'liveevent'])->name('liveevent');
            // Artist Live Event

            // profile view
            Route::get('profile', [App\Http\Controllers\Web\ArtistController::class, 'profile'])->name('profile');
            // profile view

            // Followers List
            Route::get('followers', [App\Http\Controllers\Web\ArtistController::class, 'followers'])->name('followers');
            // Followers List

            // FansList
            Route::get('fanslist/{id}', [App\Http\Controllers\Web\ArtistController::class, 'fanslist'])->name('fanslist');
            // FansList

            // Followers List
            Route::get('userscount/{id}', [App\Http\Controllers\Web\ArtistController::class, 'userscount'])->name('userscount');
            // Followers List

            //Event CRUD
            Route::get('eventCreate', [App\Http\Controllers\Web\EventController::class, 'eventCreate'])->name('eventCreate');
            Route::post('eventStore', [App\Http\Controllers\Web\EventController::class, 'eventStore'])->name('eventStore');
            Route::get('eventDetail/{id}', [App\Http\Controllers\Web\EventController::class, 'eventview'])->name('eventDetail');
            Route::get('eventEdit/{id}', [App\Http\Controllers\Web\EventController::class, 'eventedit'])->name('eventEdit');
            Route::post('eventUpdate/{id}', [App\Http\Controllers\Web\EventController::class, 'eventUpdate'])->name('eventUpdate');
            Route::get('eventDelete/{id}', [App\Http\Controllers\Web\EventController::class, 'eventDelete'])->name('eventDelete');
            //Event CRUD
            
            // startevent
            Route::post('startevent', [App\Http\Controllers\Web\EventController::class, 'startevent'])->name('startevent');
            Route::post('startendevent', [App\Http\Controllers\Web\EventController::class, 'startendevent'])->name('startendevent');
            Route::get('artiststartevent/{id}', [App\Http\Controllers\Web\EventController::class, 'artiststartevent'])->name('artiststartevent');
            Route::post('endlive', [App\Http\Controllers\Web\EventController::class, 'endlive'])->name('endlive');
            Route::get('golive/{id}', [App\Http\Controllers\Web\EventController::class, 'golive'])->name('golive');
            Route::get('activitycount/{id}', [App\Http\Controllers\Web\GoliveController::class, 'activitycount'])->name('activitycount');
            Route::get('livefancount/{id}', [App\Http\Controllers\Web\GoliveController::class, 'livefancount'])->name('livefancount');
            // startevent

            // livefanactioncount
            Route::get('livefanactioncount/{id}', [App\Http\Controllers\Web\GoliveController::class, 'livefanactioncount'])->name('livefanactioncount');
            Route::get('fansactivitysummary/{id}', [App\Http\Controllers\Web\GoliveController::class, 'fansactivitysummary'])->name('fansactivitysummary');
            Route::get('actiongraphcount1/{id}', [App\Http\Controllers\Web\GoliveController::class, 'actiongraphcount1'])->name('actiongraphcount1');
            // livefanactioncount

               //Event History
               Route::get('event-history', [App\Http\Controllers\Web\EventHistoryController::class, 'eventHistory'])->name('eventHistory');
               Route::get('event-history-details/{id}', [App\Http\Controllers\Web\EventHistoryController::class, 'eventHistoryDetails'])->name('eventHistoryDetails');
               //Event History

            //contact
            Route::get('contact', [App\Http\Controllers\Web\ContactController::class, 'contactView'])->name('contact');
            Route::post('contactcreate', [App\Http\Controllers\Web\ContactController::class, 'contactSave'])->name('contactcreates');
            //contact
                });
            // Artist about
            Route::get('aboutus', [App\Http\Controllers\Web\MainController::class, 'about'])->name('aboutus');
            // Artist about

             // Artist Terms & Condition
             Route::get('termscondition', [App\Http\Controllers\Web\ArtistController::class, 'termscondition'])->name('termscondition');
             // Artist Terms & Condition

            // Artist Privacy
            Route::get('privacypolicy', [App\Http\Controllers\Web\ArtistController::class, 'privacypolicy'])->name('privacypolicy');
            // Artist Privacy

             Route::get('editprofile', [App\Http\Controllers\Web\ArtistController::class, 'editprofile'])->name('editprofile');
             Route::post('artistupdate', [App\Http\Controllers\Web\ArtistController::class, 'artistupdate'])->name('artistupdate');
             // Artist about
            //  Change Password
            Route::post('changepasswordweb', [App\Http\Controllers\Web\ArtistController::class, 'changepassword'])->name('changepasswordweb');
            //  Change Password
            });

            //  Billing Information
            Route::post('billinginformationweb', [App\Http\Controllers\Web\ArtistController::class, 'billinginformation'])->name('billinginformationweb');
            //  Billing Information
            
            // Artist Subscription
            Route::get('subscription', [App\Http\Controllers\Web\MainController::class, 'subscription'])->name('subscription');
            Route::post('subscription', [App\Http\Controllers\Web\MainController::class, 'subscriptionPost'])->name('subscription.post');
            Route::get('subscription-payment/{id}', [App\Http\Controllers\Web\MainController::class, 'subscriptionPayment'])->name('subscription-payment');
            // Artist Subscription

            // Artist Subscription
            Route::get('billinginfo', [App\Http\Controllers\Web\MainController::class, 'billinginfo'])->name('billinginfo');
            // Artist Subscription

        });
        Route::get('aboutUs', [App\Http\Controllers\Web\SettingController::class, 'aboutUs'])->name('aboutUs');
        Route::get('introductory', [App\Http\Controllers\Web\IntroductoryscreenController::class, 'introductory'])->name('introductory');
        

       // Login Page
        Route::get('login', [App\Http\Controllers\Web\LoginController::class, 'login'])->name('login');
        Route::post('loginstore', [App\Http\Controllers\Web\LoginController::class, 'loginstore'])->name('loginstore');
         Route::get('register', [App\Http\Controllers\Web\LoginController::class, 'register'])->name('register');
        Route::post('registerstore', [App\Http\Controllers\Web\LoginController::class, 'registerstore'])->name('registerstore');
        Route::get('otp/{uuid}/{type}', [App\Http\Controllers\Web\LoginController::class, 'otp'])->name('otp');
        Route::post('otpverification', [App\Http\Controllers\Web\LoginController::class, 'otpverification'])->name('otpverification');
        Route::get('forgotpassword', [App\Http\Controllers\Web\LoginController::class, 'forgotpassword'])->name('forgotpassword');
        Route::post('forgotpasswordcheck', [App\Http\Controllers\Web\LoginController::class, 'forgotpasswordcheck'])->name('forgotpasswordcheck');

        Route::get('changepassword/{uuid}', [App\Http\Controllers\Web\LoginController::class, 'changepassword'])->name('changepassword');
        Route::post('changepasswordstore', [App\Http\Controllers\Web\LoginController::class, 'changepasswordstore'])->name('changepasswordstore');

        Route::post('resendotp', [App\Http\Controllers\Web\LoginController::class, 'resendotp'])->name('resendotp');
        // Login Page
        Route::get('logout', '\App\Http\Controllers\Web\LoginController@logout')->name('logout');
    });

    Route::get('/', [App\Http\Controllers\Fan\LoginController::class, 'login'])->name('login');
    
    Route::group(['prefix' => 'fan'], function ()
    {
        Route::get('login', [App\Http\Controllers\Fan\LoginController::class, 'login'])->name('login');
        Route::post('loginstore', [App\Http\Controllers\Fan\LoginController::class, 'loginstore'])->name('loginstore');
        Route::get('register', [App\Http\Controllers\Fan\LoginController::class, 'register'])->name('register');
        Route::post('registerstore', [App\Http\Controllers\Fan\LoginController::class, 'registerstore'])->name('registerstore');
        Route::get('forgotpassword', [App\Http\Controllers\Fan\LoginController::class, 'forgotpassword'])->name('forgotpassword');
        Route::post('forgotpasswordcheck', [App\Http\Controllers\Fan\LoginController::class, 'forgotpasswordcheck'])->name('forgotpasswordcheck');
        Route::get('otp/{uuid}/{type}', [App\Http\Controllers\Fan\LoginController::class, 'otp'])->name('otp');
        Route::post('otpverification', [App\Http\Controllers\Fan\LoginController::class, 'otpverification'])->name('otpverification');
        Route::get('changepassword/{uuid}', [App\Http\Controllers\Fan\LoginController::class, 'changepassword'])->name('changepassword');
        Route::post('changepasswordstore', [App\Http\Controllers\Fan\LoginController::class, 'changepasswordstore'])->name('changepasswordstore');
        Route::post('resentotp', [App\Http\Controllers\Fan\LoginController::class, 'resendotp'])->name('resentotp');

        Route::get('logout', [App\Http\Controllers\Fan\LoginController::class, 'logout'])->name('logout');
 // socket test
 Route::get('socket', [App\Http\Controllers\Fan\HomeController::class, 'socket'])->name('socket');

 // socket test
        Route::group(['middleware' => ['auth', 'fan']], function ()
        {

           
            // Home Page
            Route::get('fanhome', [App\Http\Controllers\Fan\HomeController::class, 'homepage'])->name('fanhome');
            // Home Page
            // Show Live Event Page
            Route::get('show-liveevent', [App\Http\Controllers\Fan\HomeController::class, 'showliveevent'])->name('show-liveevent');
            // Show Live Event Page

            // Schedule Event Page
            Route::get('show-scheduleevent', [App\Http\Controllers\Fan\HomeController::class, 'showscheduleevent'])->name('show-scheduleevent');
            // Schedule Event Page
            
            Route::get('live-event/{id}', [App\Http\Controllers\Fan\HomeController::class, 'liveEvent'])->name('live-event');
            Route::get('scheduled-event/{id}', [App\Http\Controllers\Fan\HomeController::class, 'scheduledEvent'])->name('scheduled-event');

            // News Letter
            Route::post('newsletter', [App\Http\Controllers\Fan\HomeController::class, 'newsletter'])->name('newsletter');
            // News Letter

            // My Event
            Route::get('myevent', [App\Http\Controllers\Fan\EventController::class, 'myevent'])->name('myevent');
            // My Event

            //Profile
            Route::get('edit-profile', [App\Http\Controllers\Fan\HomeController::class, 'editProfile'])->name('editProfile');
            Route::post('profile-store', [App\Http\Controllers\Fan\HomeController::class, 'profileStore'])->name('profileStore');
            // Profile

            Route::post('change-password', [App\Http\Controllers\Fan\HomeController::class, 'changePassword'])->name('changePassword');
            Route::post('changepasswordfan', [App\Http\Controllers\Fan\HomeController::class, 'changePasswordfan'])->name('changepasswordfan');

            Route::post('timezone_no', [App\Http\Controllers\Fan\HomeController::class, 'timezone_no'])->name('timezone_no');
            // Artist Profile
            Route::get('artistprofile/{id}', [App\Http\Controllers\Fan\ArtistController::class, 'artistprofile'])->name('artistprofile');
            // Artist Profile

              //About
              Route::get('about', [App\Http\Controllers\Fan\HomeController::class, 'about'])->name('about');
              // About
 
             //Term
             Route::get('term', [App\Http\Controllers\Fan\HomeController::class, 'term'])->name('term');
              // Term
 
              
             //Term
             Route::get('privacy', [App\Http\Controllers\Fan\HomeController::class, 'privacy'])->name('privacy');
             // Term
 
               
             //Term
             Route::get('favorites', [App\Http\Controllers\Fan\HomeController::class, 'favorites'])->name('favorites');
             // Term
 
             //Term
             Route::get('premium', [App\Http\Controllers\Fan\HomeController::class, 'premium'])->name('premium');
             // Term

              //Term
              Route::any('advance-search', [App\Http\Controllers\Fan\HomeController::class, 'advanceSearch'])->name('advanceSearch');
              // Term

              Route::post('favorites-update', [App\Http\Controllers\Fan\HomeController::class, 'favoritesUpdate'])->name('favoritesUpdate');

             //contact
             Route::get('contact', [App\Http\Controllers\Fan\ContactController::class, 'contactView'])->name('contact');
             Route::post('contactcreate', [App\Http\Controllers\Fan\ContactController::class, 'contactSave'])->name('contactcreate');
             //contact

            //  Event Booking and Cancel
            Route::post('cancelbooking', [App\Http\Controllers\Fan\EventbookingController::class, 'cancelbooking'])->name('cancelbooking');
            Route::post('savebookevent', [App\Http\Controllers\Fan\EventbookingController::class, 'savebookevent'])->name('savebookevent');

                // Fan Subscription
                Route::post('subscription', [App\Http\Controllers\Fan\EventbookingController::class, 'subscriptionPost'])->name('subscription.posts');
                Route::get('subscriptions-payment/{id}', [App\Http\Controllers\Fan\EventbookingController::class, 'bookevent'])->name('bookevent');
                Route::get('freebookevent/{id}', [App\Http\Controllers\Fan\EventbookingController::class, 'freebookevent'])->name('freebookevent');
                // Fan Subscription
                
                // golive
                Route::get('golive/{id}', [App\Http\Controllers\Fan\GoliveController::class, 'golive'])->name('golive');
                Route::get('livecount/{id}', [App\Http\Controllers\Fan\GoliveController::class, 'livecount'])->name('livecount');
                Route::get('liveshow/{id}', [App\Http\Controllers\Fan\GoliveController::class, 'liveshow'])->name('liveshow');
                Route::post('exitliveevent', [App\Http\Controllers\Fan\GoliveController::class, 'exitliveevent'])->name('exitliveevent');
                Route::post('exitliveeventapi', [App\Http\Controllers\Fan\GoliveController::class, 'exitliveeventapi'])->name('exitliveeventapi');
                // actionCount
                Route::post('actioncount', [App\Http\Controllers\Fan\GoliveController::class, 'actioncount'])->name('actioncount');
                Route::get('actiongraphcount/{id}', [App\Http\Controllers\Fan\GoliveController::class, 'actiongraphcount'])->name('actiongraphcount');
                Route::get('totalactioncount/{id}', [App\Http\Controllers\Fan\GoliveController::class, 'totalactioncount'])->name('totalactioncount');
                // actionCount

                // tips
                Route::get('tips/{id}/{amount}', [App\Http\Controllers\Fan\EventbookingController::class, 'tips'])->name('tips');
                Route::post('tipspaid', [App\Http\Controllers\Fan\EventbookingController::class, 'tipspost'])->name('tipspaid.posts');
                // tips


                // check join event
                Route::post('checkjoinevent', [App\Http\Controllers\Fan\GoliveController::class, 'checkjoinevent'])->name('checkjoinevent');
                // check join event

                // check book count
                Route::post('checkjoinevent', [App\Http\Controllers\Fan\EventbookingController::class, 'checkjoinevent'])->name('checkjoinevent');
                // check book count
                // golive
               
                // billing information
                Route::get('edit-billinginfo', [App\Http\Controllers\Fan\HomeController::class, 'editbillinginfo'])->name('editbillinginfo');
                Route::post('billinginformation', [App\Http\Controllers\Fan\HomeController::class, 'billinginfo'])->name('billinginformation');
                // billing information

            // book event page
            // Route::get('bookevent/{id}', [App\Http\Controllers\Fan\EventbookingController::class, 'bookevent'])->name('bookevent');
            // book event page
            //  Event Booking and Cancel
        });
      
    });
