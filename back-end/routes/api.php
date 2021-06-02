<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\messageController;
use App\Http\Controllers\userInformationController;
use App\Http\Controllers\addressController;
use App\Http\Controllers\educationController;
use App\Http\Controllers\followController;
use App\Http\Controllers\forgotPasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\resetPasswordController;
use App\Http\Controllers\transactionController;
use App\Http\Controllers\shoppingOffersController;
use App\Http\Controllers\shoppingOrdersController;
use App\Http\Controllers\reviewsController;
use App\Http\Controllers\shoppingListController;
use App\Http\Controllers\reviewController;
use App\Http\Controllers\interestController;
use App\Http\Controllers\skillsController;
use App\Http\Controllers\userAboutController;
use App\Http\Controllers\verificationIDController;
use App\Http\Controllers\saerchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::group(['middleware' => ['auth:sanctum']], function () {
	Route::get('/user/posts', [PostController::class, 'get_user_posts']);
	Route::post('post/offer', [PostController::class, 'create_offer_post']);
	Route::post('post/request', [PostController::class, 'create_request_post']);
    Route::get('/getPersonal', [userInformationController::class, 'getPersonal']);
    Route::get('/getAddress', [userInformationController::class, 'getAddress']);
    Route::get('/getLanguages', [userInformationController::class, 'getLanguages']);
    Route::get('/getWorks', [userInformationController::class, 'getWorks']);
    Route::post('/editPersonal', [userInformationController::class, 'editPersonal']);
    Route::post('/editAddress', [addressController::class, 'editAddress']);
    Route::post('/editAccount', [userInformationController::class, 'editAccount']);
    Route::get('/getValidID', [userInformationController::class, 'getValidID']);
    Route::get('/getChatroom', [messageController::class, 'getChatroom']);
    Route::get('/getMessages', [messageController::class, 'getMessages']);
    Route::post('/sendMessage', [messageController::class, 'sendMessage']);
    Route::get('/getPosts', [PostController::class, 'getAllPosts']);
    Route::post('/share', [PostController::class, 'sharePost']);
    Route::get('/getShares', [PostController::class, 'getAllShares']);
    Route::get('/getNotifications', [NotificationController::class, 'getAll']);
    Route::get('/getUnreadNotifications', [NotificationController::class, 'getUnread']);
    Route::post('/readNotif', [NotificationController::class, 'readNotif']);
    Route::post('/readMessageNotif', [NotificationController::class, 'readMessageNotif']);
    Route::post('/changeEmail', [userInformationController::class, 'changeEmail']);
    Route::post('/changePassword', [userInformationController::class, 'changePassword']);
    Route::post('/confirmUser', [userInformationController::class, 'confirmUser']);
    Route::post('/updateProfilePic', [userInformationController::class, 'updateProfilePic']);
    Route::post('/createChatRoom', [messageController::class, 'createRoom']);
    Route::post('/createTransaction', [transactionController::class, 'createTransaction']);
    Route::get('/getTransaction', [transactionController::class, 'getTransaction']);
    Route::post('/cancelTransaction', [transactionController::class, 'cancelTransaction']);
    Route::post('/declineRequest', [transactionController::class, 'declineRequest']);
    Route::get('/getShippingAddress', [addressController::class, 'getShippingAddress']);
    Route::get('/getTransportModes', [addressController::class, 'getTransportModes']);
    Route::get('/getShoppingPlaces', [addressController::class, 'getShoppingPlaces']);
    Route::get('/getUserInfo', [userInformationController::class, 'getUserInfo']);
    Route::get('/getNotAuthUserAddress', [addressController::class, 'getNotAuthUserAddress']);
    Route::post('/addNewShipping', [addressController::class, 'addNewShipping']);
    Route::post('/editShipping', [addressController::class, 'editShipping']);
    Route::post('/confirmRequest', [transactionController::class, 'confirmRequest']);
    Route::post('/updateTransaction', [transactionController::class, 'updateTransaction']);
    Route::post('/editListDeliverStatus/{transNum}', [transactionController::class, 'editListDeliverStatus']);
    Route::get('/getShoppingList', [shoppingListController::class, 'getShoppingList']);
    Route::post('/editList/{listNum}', [shoppingListController::class, 'editList']);
    Route::post('/createList', [shoppingListController::class, 'createList']);
    Route::delete('/deleteList/{listNum}', [shoppingListController::class, 'deleteList']);
	Route::post('/editPostStatus', [PostController::class, 'editPostStatus']);
	Route::post('/followStatus', [followController::class, 'followStatus']);
	Route::get('/getUserFollow', [followController::class, 'getUserFollow']);
    Route::get("shoppingoffers",[shoppingOffersController::class, 'listShoppingOffers']);
    //Route::post("shoppingoffers",[shoppingOffersController::class, 'addShoppingOffers']);
    Route::post("/editshoppingoffers",[shoppingOffersController::class, 'editshoppingoffers']);
    Route::get("shoppingorders",[shoppingOrdersController::class, 'listShoppingOrders']);
    //Route::put("editShoppingOffers",[shoppingOffersController::class, 'update']);
    Route::get("/getReviews",[reviewController::class, 'listReviews']);
    Route::put('post/{post_id}/edit', [PostController::class, 'editPost']);
    Route::delete('post/{post_id}/delete', [PostController::class, 'deletePost']);
    Route::get("/userinterest", [interestController::class, 'getInterest']);
    Route::get("/userSkills", [interestController::class, 'getSkills']);
    Route::post("/userReviews", [reviewController::class, 'saveReview']);
    Route::delete("/clearNotif", [NotificationController::class, 'clearNotif']);
    Route::post("/updateEduc", [educationController::class, 'updateEduc']);
    Route::get("/getEduc", [educationController::class, 'getEduc']);
    Route::get("/getVerifiedUsers", [verificationIDController::class, 'getVerifiedUsers']);
    Route::post("/postIDAccSet", [userInformationController::class, 'postID']);
    Route::get("/search", [searchController::class, 'search']);
    
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});



Route::post('login',[loginController::class, 'login'] )->name('login');
Route::post('sendCode',[RegisterController::class, 'sendCode'] );
Route::post('postPersonal',[RegisterController::class, 'postPersonal'] );
Route::post('postID',[RegisterController::class, 'postID'] );
Route::post('postAddress',[RegisterController::class, 'postAddress'] );
Route::post('register',[RegisterController::class, 'register'] );
Route::post('logout',[loginController::class, 'logout'] );
Route::get('refProvince',[addressController::class, 'refProvince'] );
Route::get('refcityMunicipality',[addressController::class, 'refcityMunicipality'] );
Route::get('refBrgy',[addressController::class, 'refBrgy'] );

Route::post('/password/email',[forgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/password/reset',[resetPasswordController::class, 'reset'] );

Route::post('/confirmVerificationCode', [RegisterController::class, 'confirmCode']);
Route::get('user/feed', [PostController::class, 'getFeeds']);

Route::post('/confirmVerificationCode', [RegisterController::class, 'confirmCode']);
Route::get("shoppingoffers",[shoppingOffersController::class, 'listShoppingOffers']);
//Route::post("shoppingoffers",[shoppingOffersController::class, 'addShoppingOffers']);
Route::post("/editshoppingoffers",[shoppingOffersController::class, 'editshoppingoffers']);
Route::get("shoppingorders",[shoppingOrdersController::class, 'listShoppingOrders']);
//Route::put("editShoppingOffers",[shoppingOffersController::class, 'update']);
Route::get("/getReviews",[reviewController::class, 'listReviews']);
Route::post('/confirmVerificationCode', [RegisterController::class, 'confirmCode']);
//Route::get("/userinterest", [interestController::class, 'getInterest']);
//Route::get("/userSkills", [interestController::class, 'getSkills']);
Route::post("/userReviews", [reviewController::class, 'saveReview']);
Route::get("/listInterest", [interestController::class, 'getListInterests']);
//Route::get("/listSkills", [skillsController::class, 'getListSkills']);
//Route::get("/listSkills", [skillsController::class, 'getListSkills']);
Route::get("/listSkills", [skillsController::class, 'getListSkills'] );
Route::post("/postSkill", [userAboutController::class, 'postUserSkills'] );
Route::post("/updateSkill", [userAboutController::class, 'updateUserSkills'] );
Route::post("/postInterest", [userAboutController::class, 'postUserInterests'] );
Route::post("/updateInterest", [userAboutController::class, 'updateUserInterests'] );
Route::post("/postVisitedPlace", [userAboutController::class, 'postUserVisitedPlaces'] );
Route::post("/updateVisitedPlace", [userAboutController::class, 'updateUserVisitedPlaces'] );
Route::get("/allLanguages", [userInformationController::class, 'getAllLanguages'] );
Route::get("/getUserAbout", [userAboutController::class, 'getUserAbout'] );
Route::get("/getAllTransactions", [transactionController::class, 'getAllTransactions'] );

