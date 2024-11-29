<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([''], function () {

// Auth::routes();
// Route::get('/', function () {
//     return view('welcome');
// });


Route::post('/signup', 'Auth\LoginController@signup')->name('signup');
Route::post('/resend_verification_email', 'Auth\LoginController@resend_verification_email')->name('resend_verification_email');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/update', 'Auth\LoginController@update')->name('update');
Route::get('/logout', 'Auth\LoginController@apilogout')->name('logout');
Route::delete('/delete-user', 'Auth\LoginController@delete_user')->name('delete-user');
Route::post('update/user/profile/picture', 'Auth\LoginController@updateProfilePicture')->name('update-user-profile');

Route::post('/get_agent_details/{id}', 'Auth\LoginController@get_agent_details')->name('get_agent_details');
Route::get('/get/user_details/{id}', 'Auth\LoginController@getUserDetails')->name('get_user_details');


Route::post('/customer/forgot-password', 'Auth\LoginController@customerSendResetLink');
Route::post('/customer/reset-password', 'Auth\LoginController@CustomerResetPassword');

// agent
Route::post('/agent/forgot-password', 'Auth\LoginController@agentSendResetLink');
Route::post('/agent/reset-password', 'Auth\LoginController@agentResetPassword');

Route::get('/', 'HomeController@index')->name('home'); //Done
Route::get('/package-detail/{id}','HomeController@package_details')->name('package-detail'); //Done
Route::get('/agency-detail/{id}','HomeController@agency_details')->name('agency-detail'); //Done
Route::post('book','HomeController@book')->name('book'); //Done
Route::get('profile/{id}','HomeController@profile')->name('profile'); //Done
Route::get('about','HomeController@about')->name('about'); //Done
Route::get('blog','HomeController@blog')->name('blog'); //Done
Route::get('/blog-detail/{id}','HomeController@blog_detail')->name('blog-detail'); //Done
Route::get('umrah','HomeController@umrah')->name('umrah'); //Done
Route::get('hajj','HomeController@hajj')->name('hajj'); //Done
Route::get('contact','HomeController@contact')->name('contact'); //Done
Route::post('post_contact','HomeController@post_contact')->name('post_contact'); //Done Check
Route::post('add-comment','HomeController@add_comment')->name('add_comment');
Route::post('add-review','HomeController@add_review')->name('add_review');
Route::post('customize-packages','HomeController@customize_packages')->name('customize_packages');
Route::post('favorite/package/{id}','HomeController@favoritePackage')->name('favorite.package');
Route::get('favorite/packages','HomeController@getFavoritePackages')->name('get.favorite.packages');
Route::get('remove/favorite/package/{id}','HomeController@removeFavoritePackage')->name('remove.favorite.packages');

Route::get('show-agency/{id}','Admin\AgencyController@showAgentAgencies')->name('show.agency');
Route::post('update-agency/{id}','Admin\AgencyController@updateAgencyByAgent')->name('update.agency');
Route::post('create-package/{id}','Admin\PackageController@createPackageByAgent')->name('package.store');
Route::get('show-packages/{id}','Admin\PackageController@displayAgentPackages')->name('show.package');
Route::get('view-package/{id}','Admin\PackageController@viewPackage')->name('view.package');
Route::post('/update-package/{id}','Admin\PackageController@update')->name('update.package');
Route::get('/delete-package/{id}', 'Admin\PackageController@destroy')->name('delete.package');

});

Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');
Route::get('email/verify/agent/{id}', 'VerificationApiController@verifyAgent')->name('verificationapi.agent.verify');
Route::get('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend');

Route::post('/send-verification-code', [SmsController::class, 'sendVerificationCode']);
Route::post('/verifyCode', [SmsController::class, 'verifyCode']);
Route::post('/requestPasswordReset', [SmsController::class, 'requestPasswordReset']);
Route::post('/resetPassword', [SmsController::class, 'resetPassword']);

Route::group(['middleware' => ['api']], function () {
   Route::post('auth/google/login', 'Auth\LoginController@loginWithGoogle');
   Route::post('auth/agent/google/login', 'Auth\LoginController@agentLoginWithGoogle');
});
