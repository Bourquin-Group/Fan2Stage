<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
//Route::post('apple-token', 'App\Http\Controllers\AppleController@getAppletoken')->name('getAppletoken');

Route::get('auth/{service}', 'App\Http\Controllers\SocialController@redirect');
Route::get('auth/{service}/callback', 'App\Http\Controllers\SocialController@callback');


  	

Route::group(['prefix' => 'users'],function () {

// mobilesociallogin
Route::post('mobilesociallogin', 'App\Http\Controllers\API\AuthController@mobilesociallogin')->name('mobilesociallogin');
// mobilesociallogin

Route::post('register', 'App\Http\Controllers\API\AuthController@register')->name('userRegister');
Route::post('login', 'App\Http\Controllers\API\AuthController@login')->name('userLogin');
Route::post('forgotpassword', 'App\Http\Controllers\API\AuthController@forgotpassword')->name('forgotpassword');
Route::post('verifyOtp', 'App\Http\Controllers\API\AuthController@verifyOtp')->name('verifyOtp');
Route::post('resetPassword', 'App\Http\Controllers\API\AuthController@resetPassword')->name('resetPassword');

// delete account
Route::delete('deleteaccount/{id}', 'App\Http\Controllers\API\AuthController@deleteaccount')->name('deleteaccount');
// delete account
Route::middleware('auth:api')->group( function () {

	Route::get('live-event','App\Http\Controllers\API\EventController@liveEventList');
	Route::get('live-eventapi','App\Http\Controllers\API\EventController@liveEventListApi');
	Route::get('scheduled-event','App\Http\Controllers\API\EventController@scheduledEventList');
	Route::get('scheduledEventListApi','App\Http\Controllers\API\EventController@scheduledEventListApi');
	Route::post('view-event','App\Http\Controllers\API\EventController@viewEventDetails');

	// Artist
	Route::post('artist-detail','App\Http\Controllers\API\ArtistController@artistDetail');
	Route::get('allArtist','App\Http\Controllers\API\ArtistController@allArtist');
	Route::post('createArtist','App\Http\Controllers\API\ArtistController@createArtist')->name('createArtist');
	Route::post('UpdateArtist','App\Http\Controllers\API\ArtistController@UpdateArtist')->name('UpdateArtist');
	Route::post('apiartist-detail/{id}','App\Http\Controllers\API\ArtistController@apiArtistDetail')->name('apiartist-detail');
	// Artist

	// Fan Subscription
	Route::post('subscription-posts', 'App\Http\Controllers\API\StripeController@subscriptionPost')->name('subscription-posts');
	Route::post('subscriptionPostapi', 'App\Http\Controllers\API\StripeController@subscriptionPostapi')->name('subscriptionPostapi');
	Route::get('getbookevent/{id}', 'App\Http\Controllers\API\StripeController@bookevent')->name('getbookevent');
	// Fan Subscription

	// ArtistEvent
	Route::post('artischeduleEvent','App\Http\Controllers\API\Artist_eventController@artischeduleEvent')->name('artischeduleEvent');
	Route::post('liveEvent','App\Http\Controllers\API\Artist_eventController@liveEvent')->name('liveEvent');
	Route::post('pastEvents','App\Http\Controllers\API\Artist_eventController@pastEvent')->name('pastEvents');
	// ArtistEvent

	// FansEvent
	Route::get('fansEvent','App\Http\Controllers\API\Fans_eventController@fansEvent')->name('fansEvent');
	Route::get('fansEventApi','App\Http\Controllers\API\Fans_eventController@fansEventApi')->name('fansEventApi');
	Route::post('pastEvent','App\Http\Controllers\API\Fans_eventController@pastEvent')->name('pastEvent');
	Route::post('upcomingEvent','App\Http\Controllers\API\Fans_eventController@upcomingEvent')->name('upcomingEvent');
	Route::post('filterpastEvent','App\Http\Controllers\API\Fans_eventController@filterpastEvent')->name('filterpastEvent');
	Route::post('filterupcomingEvent','App\Http\Controllers\API\Fans_eventController@filterupcomingEvent')->name('filterupcomingEvent');
	// FansEvent

	// Favourite
	Route::post('add-favourite','App\Http\Controllers\API\FavouritesController@addFavourite');
	Route::get('list-favourite','App\Http\Controllers\API\FavouritesController@listFavourite');
	// Favourite

    // event
	Route::get('eventall','App\Http\Controllers\API\EventController@eventall')->name('eventall');
	Route::post('eventcreate','App\Http\Controllers\API\EventController@eventcreate')->name('eventcreate');
	Route::post('eventupdate/{id}','App\Http\Controllers\API\EventController@eventupdate')->name('eventupdate');
	Route::post('eventshow/{id}','App\Http\Controllers\API\EventController@eventshow')->name('eventshow');
	Route::get('eventdestroy/{id}','App\Http\Controllers\API\EventController@eventdestroy')->name('eventdestroy');

	Route::post('startevent','App\Http\Controllers\API\EventController@startevent')->name('startevent');
	Route::post('endevent','App\Http\Controllers\API\EventController@endevent')->name('endevent');
    // event

    // Event Booking
	Route::post('Eventbooking','App\Http\Controllers\API\EventbookingController@Eventbooking')->name('Eventbooking');
	Route::get('bookingevents/{id}','App\Http\Controllers\API\EventbookingController@bookingevents')->name('bookingevents');
	Route::get('cancelbooking/{id}','App\Http\Controllers\API\EventbookingController@cancelbooking')->name('cancelbooking');
	Route::get('freebookevent/{id}', 'App\Http\Controllers\API\EventbookingController@freebookevent')->name('freebookevent');
	Route::post('checkprebooking', 'App\Http\Controllers\API\EventbookingController@checkprebooking')->name('checkprebooking');
    // Event Booking

	// Booking Event Filter
	Route::post('bookingeventFilter','App\Http\Controllers\API\EventbookingController@bookingeventFilter')->name('bookingeventFilter');
	// Booking Event Filter
	
	// Join and Exit Event
	Route::post('joinEvent','App\Http\Controllers\API\EventbookingController@joinEvent')->name('joinEvent');
	Route::post('exitEvent','App\Http\Controllers\API\EventbookingController@exitEvent')->name('exitEvent');
	Route::post('exiteventapi','App\Http\Controllers\API\EventbookingController@exiteventapi')->name('exiteventapi');
	// Join and Exit Event
	
	// donation
	Route::post('donation','App\Http\Controllers\API\LiveEventController@Donation')->name('donation');
	// donation
	Route::post('tipspaid', 'App\Http\Controllers\API\StripeController@tipspost')->name('tipspaid');
	
	// ratings
	Route::post('ratings','App\Http\Controllers\API\FeedbackController@event_Joined_by_fans')->name('ratings');
	// ratings

	// actions
	Route::get('actionall','App\Http\Controllers\API\ActionController@actionall')->name('actionall');
	Route::post('actioncreate','App\Http\Controllers\API\ActionController@actioncreate')->name('actioncreate');
	Route::post('actionupdate/{id}','App\Http\Controllers\API\ActionController@actionupdate')->name('actionupdate');
	Route::get('actiondestroy/{id}','App\Http\Controllers\API\ActionController@actiondestroy')->name('actiondestroy');
	// actions

	// Useraction
	Route::post('getUseraction','App\Http\Controllers\API\UseractionController@getUseraction')->name('getUseraction');
	// Useraction

	// Newsletter
	Route::get('newsall','App\Http\Controllers\API\NewsletterController@newsall')->name('newsall');
	Route::post('newscreate','App\Http\Controllers\API\NewsletterController@newscreate')->name('newscreate');
	// Newsletter
	
	// Artist Filter
	Route::post('artistFilter','App\Http\Controllers\API\ArtistfilterController@artistFilter')->name('artistFilter');
	// Artist Filter

	// Event Filter
	Route::post('eventFilter','App\Http\Controllers\API\EventfilterController@eventFilter')->name('eventFilter');
	Route::post('eventFilterApi','App\Http\Controllers\API\EventfilterController@eventFilterApi')->name('eventFilterApi');
	// Event Filter

	// subscription plan
	Route::get('subscriptionplanlist','App\Http\Controllers\API\SubscriptionPlanController@subscriptionplanlist')->name('subscriptionplanlist');
	// subscription plan

	// Artist F2S Plan List
	Route::get('artistf2splanlist','App\Http\Controllers\API\SubscriptionPlanController@artistf2splanlist')->name('artistf2splanlist');
	Route::post('f2splanselect','App\Http\Controllers\API\SubscriptionPlanController@f2splanselect')->name('f2splanselect');
	// Artist F2S Plan List

	// Notication
	Route::get('list-favourite-event','App\Http\Controllers\API\NotificationController@listFavouriteEvent')->name('favourite-event');
	Route::get('event-booking-cancel','App\Http\Controllers\API\NotificationController@eventBookingCancel')->name('event-booking-cancel');
	Route::get('notification_history','App\Http\Controllers\API\NotificationController@notification_history')->name('notification_history');
	Route::get('notifyread/{id}','App\Http\Controllers\API\NotificationController@notifyread')->name('notifyread');
	Route::get('notifyreadapi/{id}','App\Http\Controllers\API\NotificationController@notifyreadapi')->name('notifyreadapi');
	Route::get('notifyreadall','App\Http\Controllers\API\NotificationController@notifyreadall')->name('notifyreadall');
	Route::get('notification_historyapi','App\Http\Controllers\API\NotificationController@notification_historyapi')->name('notification_historyapi');
	Route::post('updateDeviceToken','App\Http\Controllers\API\NotificationController@updateDeviceToken')->name('updateDeviceToken');
	// Notication
	
    // Route::resource('products', 'App\Http\Controllers\API\ProductController');
    Route::resource('events', 'App\Http\Controllers\API\EventController');
    Route::get('logout', 'App\Http\Controllers\API\AuthController@logout');
    Route::get('view-profile', 'App\Http\Controllers\API\AuthController@viewProfile')->name('viewUserProfile');
    Route::post('update-profile', 'App\Http\Controllers\API\AuthController@updateProfile')->name('updateUserProfile');
    Route::post('change-password', 'App\Http\Controllers\API\AuthController@changePassword')->name('postChangePassword');
	


	// Billing Information
	Route::get('getbillinfo', 'App\Http\Controllers\API\AuthController@getbillinfo')->name('getbillinfo');
    Route::post('storebillinginfo', 'App\Http\Controllers\API\AuthController@storebillinginfo')->name('storebillinginfo');
	// Billing Information
	
	// join event
	Route::post('golive/{id}', 'App\Http\Controllers\API\GoliveController@golive')->name('golive');
	Route::post('checklive/{id}', 'App\Http\Controllers\API\GoliveController@checklive')->name('checklive');
	Route::post('livecount/{id}', 'App\Http\Controllers\API\GoliveController@livecount')->name('livecount');
	// join event
	
	// Fans Action Count
	Route::post('actioncount', 'App\Http\Controllers\API\GoliveController@actioncount')->name('actioncount');
	Route::get('actiongraphcount/{id}', 'App\Http\Controllers\API\GoliveController@actiongraphcount')->name('actiongraphcount');
	// Fans Action Count
});

});
Route::post('alllogoutapi', 'App\Http\Controllers\API\AuthController@alllogoutsapi')->name('alllogoutapi');
Route::post('allsociallogoutapi', 'App\Http\Controllers\API\AuthController@allsociallogoutsapi')->name('allsociallogoutapi');
//CMS
Route::get('about-us','App\Http\Controllers\API\CmsManageController@aboutus')->name('aboutus');
Route::get('privacy-policy','App\Http\Controllers\API\CmsManageController@privacypolicy')->name('privacypolicy');
Route::get('terms-and-condition','App\Http\Controllers\API\CmsManageController@termsandcondition')->name('termsandcondition');
//CMS

// Introductory Screen
Route::get('introductory-screen','App\Http\Controllers\API\IntroductoryscreenController@introductoryScreen')->name('introductory-screen');
// Introductory Screen
