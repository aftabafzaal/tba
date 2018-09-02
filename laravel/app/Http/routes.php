<?php

Route::post('crop', 'CropController@postCrop');
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('how-to-order', 'HomeController@howtoorder');
Route::get('about-us', 'HomeController@aboutus');
Route::get('terms', 'HomeController@terms');
Route::get('agreement', 'HomeController@agreement');
Route::get('privacy', 'HomeController@privacy');
Route::get('contact-us', 'ContactusController@index');
Route::get('get-started', 'HomeController@getstarted');

Route::controllers(['auth' => 'Auth\AuthController', 'password' => 'Auth\PasswordController',]);
Route::post('contact-send', 'ContactusController@store');
Route::get('search', 'HomeController@search');
Route::get('products', 'HomeController@products');
Route::get('shop', 'HomeController@products');
Route::get('product/{id}', 'HomeController@getproduct');
Route::get('apparel/{id}', 'HomeController@getproduct');
Route::get('page/{code}', 'PageController@view');

Route::get('products/{id}', 'HomeController@products');
Route::get('products', 'HomeController@products');
Route::get('apparels', 'HomeController@apparel');
Route::get('/guestbook', [
    'uses' => 'HomeController@guestbook',
    'as' => 'guestbook.messages',
]);

Route::get('forgot', 'SignupController@forgot_password');
Route::post('reset', 'SignupController@reset_password');
Route::post('savemessage', 'HomeController@messagePost');
Route::get('page/{code}', 'PageController@view');
Route::get('myorders', 'OrdersController@myorders');
Route::get('order/{id}', 'OrdersController@order');
Route::get('cart/add', 'CartController@add');
Route::get('cart/addsimple', 'CartController@addsimple');
Route::get('cart/updateproductprice', 'CartController@updateproductprice');
Route::get('cart/view', 'CartController@mycart');
Route::get('cart/', 'CartController@mycart');
Route::get('cart/delete/{id}', 'CartController@delete');
Route::get('cart/update', 'CartController@update');
Route::get('checkout', 'CheckoutController@index');
Route::post('postOrder', 'CheckoutController@order');
Route::get('checkout/success/{id}', 'CheckoutController@success');
Route::get('checkout/fail', 'CheckoutController@fail');
Route::get('register/success/{id}', 'SignupController@success');
Route::get('mycart', 'CartController@index');
Route::post('admin/clientOrderStatus', 'ClientsController@ordersBystatus');
//Route for Newsletter
Route::post('newsletter/store', 'NewsletterController@store');

Route::get('login', 'SignupController@login');
Route::get('signup', 'SignupController@signup');
Route::get('signup/athlete', 'SignupController@register');
Route::get('signup/ambassador', 'SignupController@register');
Route::get('signup/user', 'SignupController@register');
Route::post('/signUpPost', 'SignupController@store');
Route::post('postLogin', 'SignupController@postLogin');
Route::get('changepassword', 'CustomersController@changepassword');
Route::post('postchangepassword', 'CustomersController@postchangepassword');
Route::get('register/verify/{confirmation_code}', 'SignupController@confirmEmail');

Route::get('profile/edit', 'CustomersController@editprofile');
Route::get('professional/edit', 'ProfessionalController@edit');
Route::get('address/edit', 'AddressController@edit');

Route::get('profile', 'CustomersController@profile');

Route::get('address', 'AddressController@index');


Route::post('updateprofile', 'CustomersController@updateprofile');
Route::post('updateaddress', 'AddressController@update');



Route::get('/user/{id}', 'ProfileController@index');

Route::post('coupons/apply', 'CouponsController@apply');
Route::group(
        array('prefix' => 'paypal'), function() {
    $folder = "Payments\\";
    Route::get('success', $folder . 'PaypalController@success');
    Route::get('cancel', $folder . 'PaypalController@cancel');
}
);

Route::group(
        array('prefix' => 'check'), function() {
    $folder = "Payments\\";
    Route::get('success', $folder . 'CheckController@success');
    Route::get('cancel', $folder . 'CheckController@cancel');
}
);

Route::get('blog', 'BlogController@index');
Route::get('blog/{q}', 'BlogController@index');
Route::get('blog/post/{id}', 'BlogController@post');

Route::group(['middleware' => 'prevent-back-history'], function() {
    Route::get('athlete/register', 'AthleteController@register');
});
Route::post('save/credit-card', 'CreditCardController@save');
Route::get('state/get/{id}','AjaxController@getState');
Route::get('city/get/{id}','AjaxController@getCity');
Route::post('makeorderimage', 'HomeController@makeorderimage');
include('routes_admin.php');
