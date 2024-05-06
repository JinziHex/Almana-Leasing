<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
  $exitCode = Artisan::call('config:cache');
  $exitCode = Artisan::call('optimize:clear');
  $exitCode =  Artisan::call('schedule:run');
  return 'DONE'; //Return anything

});




Route::get('sitemap.xml', function () {
    $routes = collect(Route::getRoutes())->filter(function ($route) {
        return strpos($route->getAction('controller'), 'App\\Http\\Controllers\\Front') === 0;
    })->map(function ($route) {
        return url($route->uri());
    });

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach ($routes as $route) {
        $xml .= "\t<url>\n";
        $xml .= "\t\t<loc>{$route}</loc>\n";
        $xml .= "\t</url>\n";
    }

    $xml .= '</urlset>';

     return response($xml)->header('Content-Type', 'text/xml');
});


Route::get('/language/{locale?}', function ($locale) {
  app()->setLocale($locale);
  session()->put('locale', $locale);
  return redirect()->back();
})->name('change.language');
Route::get('bad-page','Front\HomeController@badpage')->name('bad-page');
Route::get('mail-test','Admin\BookingController@mailTest')->name('bad-page');
Route::get('/login', function () {
    return view('welcome');
});

Route::get('/web-login','Front\HomeController@weblogin');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard','HomeController@dash')->name('dashboard');

//Currency
Route::get('/admin/currency','Admin\CurrencyController@index')->name('admin.currency');
Route::get('/admin/currency/add','Admin\CurrencyController@add')->name('admin.currency.add');
Route::post('/admin/currency/save','Admin\CurrencyController@save')->name('admin.currency.save');
Route::get('currency/edit/{id}','Admin\CurrencyController@edit')->name('admin.currency.edit');
Route::post('/admin/currency/update','Admin\CurrencyController@update')->name('currency.update');
Route::get('currency/delete/{id}','Admin\CurrencyController@delete')->name('admin.currency.delete');

//city

Route::get('/admin/city','Admin\CityController@index')->name('admin.city');
Route::get('/admin/city/add','Admin\CityController@add')->name('admin.city.add');
Route::post('/admin/city/save','Admin\CityController@save')->name('admin.city.save');
Route::get('city/edit/{id}','Admin\CityController@edit')->name('admin.city.edit');
Route::post('/admin/city/update','Admin\CityController@update')->name('city.update');
Route::get('city/delete/{id}','Admin\CityController@delete')->name('admin.city.delete');

//Coupons
Route::get('/admin/coupon','Admin\CouponController@index')->name('admin.coupon');
Route::get('/admin/coupon/add','Admin\CouponController@add')->name('admin.coupon.add');
Route::post('/admin/coupon/save','Admin\CouponController@save')->name('admin.coupon.save');
Route::get('coupon/edit/{id}','Admin\CouponController@edit')->name('admin.coupon.edit');
Route::post('/admin/coupon/update','Admin\CouponController@update')->name('coupon.update');
Route::get('coupon/delete/{id}','Admin\CouponController@delete')->name('admin.coupon.delete');


//Locations
Route::get('/admin/location','Admin\CityController@locindex')->name('admin.location');
Route::get('/admin/location/add','Admin\CityController@locadd')->name('admin.location.add');
Route::post('/admin/location/save','Admin\CityController@locsave')->name('admin.location.save');
Route::get('location/edit/{id}','Admin\CityController@locedit')->name('admin.location.edit');
Route::post('/admin/location/update','Admin\CityController@locupdate')->name('location.update');
Route::get('location/delete/{id}','Admin\CityController@locdelete')->name('admin.location.delete');


//Models
Route::get('/admin/model/add','Admin\ModelController@addModel')->name('admin.model.add');
Route::post('/admin/model/save','Admin\ModelController@modelSave')->name('admin.model.save');
Route::get('/admin/models','Admin\ModelController@index')->name('admin.models');
Route::post('/image/save','Admin\ModelController@image_save')->name('image.save');
Route::post('/image/spec/save','Admin\ModelController@spec_save')->name('admin.model.spec.save');
Route::get('modal/view/{id}','Admin\ModelController@view')->name('modal.view');
Route::get('/modal/edit/{id}','Admin\ModelController@edit')->name('modal.edit');
Route::get('model/image/remove/thumb/{id}','Admin\ModelController@image_main')->name('model.thumb');
Route::get('model/image/delete/{id}','Admin\ModelController@image_delete')->name('model.image.delete');
Route::get('model/spec/delete/{id}','Admin\ModelController@spec_delete')->name('model.spec.delete');
Route::get('modal/hide/{id}','Admin\ModelController@hide_model')->name('admin.model.hide');
Route::get('modal/unhide/{id}','Admin\ModelController@unhide_model')->name('admin.model.unhide');

//connect almanasoft api and insert data
Route::get('makers-add/api','Admin\ApiConnectController@addMakers');
Route::get('model-category-add/api','Admin\ApiConnectController@addModelCategory');
Route::get('rate-types-add/api','Admin\ApiConnectController@addRateTypes');
Route::get('model-group-add/api','Admin\ApiConnectController@addModelGroup');
Route::get('models-add/api','Admin\ApiConnectController@addModels');
Route::get('models-rates-add/api','Admin\ApiConnectController@addModelRates');
Route::get('city-add/api','Admin\ApiConnectController@addCity');
Route::get('city-location-add/api','Admin\ApiConnectController@addCityLocation');
Route::get('traffic-violation/api','Admin\ApiConnectController@violationList');


//Specification
Route::get('/admin/specification','Admin\SpecController@index')->name('admin.specification');
Route::get('/admin/specification/add','Admin\SpecController@add')->name('admin.specification.add');
Route::post('/admin/specification/save','Admin\SpecController@save')->name('admin.specification.save');
Route::get('specification/edit/{id}','Admin\SpecController@edit')->name('admin.specification.edit');
Route::post('/admin/specification/update','Admin\SpecController@update')->name('specification.update');
Route::get('specification/delete/{id}','Admin\SpecController@delete')->name('admin.specification.delete');
Route::get('/admin/spec/deactivate/{id}','Admin\SpecController@deactivate')->name('spec.status.deactive');
Route::get('/admin/spec/activate/{id}','Admin\SpecController@activate')->name('spec.status.active');

//sliders
Route::get('/admin/sliders','Admin\SliderController@index')->name('admin.sliders');
Route::get('/admin/sliders/create','Admin\SliderController@create')->name('admin.sliders.create');
Route::post('/admin/sliders/save','Admin\SliderController@save')->name('admin.sliders.save');
Route::get('/admin/sliders/delete/{id}','Admin\SliderController@delete')->name('admin.sliders.delete');

//Albums
Route::resource('admin/albums', Admin\AlbumController::class)->names('admin.albums');

//Photos
Route::resource('admin/photos', Admin\PhotoController::class)->names('admin.photos');

//Ads
Route::resource('admin/ads', Admin\AdsController::class)->names('admin.ads');


//customers
Route::get('/admin/customers','Admin\CustomerController@index')->name('admin.customers');
  
Route::get('customer/deactivate/{id}','Admin\CustomerController@deactivate')->name('admin.customer.deactivate');
Route::get('customer/activate/{id}','Admin\CustomerController@activate')->name('admin.customer.activate');
Route::get('customer/view/{id}','Admin\CustomerController@view')->name('customer.view');
Route::get('customer/delete/{id}','Admin\CustomerController@delete')->name('customer.delete');
Route::get('customer/assign-coupon/{id}','Admin\CustomerController@assignCoupon')->name('customer.assign.coupon');
Route::post('customer/assign-coupon-store','Admin\CustomerController@assignCouponStore')->name('admin.customer.assign.save');
Route::get('customer/delete-coupon/{id}','Admin\CustomerController@deleteAssignedCoupon')->name('customer.coupon.delete');
//staff management
Route::get('/admin/staffs','Admin\StaffController@index')->name('admin.staffs');
Route::get('/admin/staff/add','Admin\StaffController@add')->name('admin.staff.add');
Route::post('/admin/staff/save','Admin\StaffController@save')->name('staff.save');
Route::get('staff/edit/{id}','Admin\StaffController@edit')->name('staff.edit');
Route::post('staff/update','Admin\StaffController@update')->name('staff.update');
Route::get('staff/inactivate/{id}','Admin\StaffController@inactivate')->name('staff.inactivate');
Route::get('staff/activate/{id}','Admin\StaffController@activate')->name('staff.activate');
Route::get('staff/delete/{id}','Admin\StaffController@delete')->name('staff.delete');

//promotion
Route::get('/admin/promotions','Admin\PromotionController@index')->name('admin.promotions');
Route::get('/admin/promotion/add','Admin\PromotionController@add')->name('admin.promotion.add');
Route::post('/admin/promotion/save','Admin\PromotionController@save')->name('admin.promotion.save');
Route::get('promotion/delete/{id}','Admin\PromotionController@delete')->name('promotion.delete');
Route::get('promotion/edit/{id}','Admin\PromotionController@edit')->name('promotion.edit');
Route::post('promotion/update','Admin\PromotionController@update')->name('promotion.update');

//Customer Report
Route::get('/admin/customer/report','Admin\ReportController@index')->name('admin.customer.report');
//Booking Report
Route::get('/admin/booking/report','Admin\ReportController@booking')->name('admin.booking.report');
//Model rate report
//Booking Report
Route::get('/admin/model-rates/report','Admin\ReportController@modelRateReport')->name('admin.modelrate.report');

//bookings
Route::get('/admin/bookings','Admin\BookingController@index')->name('admin.bookings');
Route::get('booking/view/{id}','Admin\BookingController@view')->name('admin.booking.view');
Route::post('/admin/book/status/change','Admin\BookingController@status')->name('admin.book.status');
Route::get('/booking/filter','Admin\BookingController@filter')->name('booking.filter');

//profile
Route::get('/admin/profile','HomeController@profile')->name('admin.profile');
Route::post('/admin/change/password','HomeController@change_password')->name('profile.change.passowrd');

//Traffic violation
Route::get('/admin/trafic/violation','Admin\TrafficController@index')->name('admin.traffic.violation');
Route::get('violation/view/{id}','Admin\TrafficController@view')->name('admin.violation.view');

//Feedbacks
Route::get('/admin/feedbacks','Admin\FeedbackController@index')->name('admin.feedbacks');
Route::get('feedback/view/{id}','Admin\FeedbackController@view')->name('admin.feedbacks.view');

//Model rates
Route::get('/admin/rates','Admin\ModelRateController@index')->name('admin.rates');
//modal filter
Route::get('modal/filter','Admin\ModelController@filter')->name('modal.filter');
//customer filter

//rate filter
Route::get('rate/filter','Admin\ModelRateController@filter')->name('rate.filter');
//customer filter
Route::get('customer/filter','Admin\CustomerController@filter')->name('customer.filter');
//staff filter
Route::get('staff/filter','Admin\StaffController@filter')->name('staff.filter');
//violation filter
Route::get('violation/filter','Admin\TrafficController@filter')->name('violation.filter');
//feedback filter
Route::get('feedback/filter','Admin\FeedbackController@filter')->name('feedback.filter');
//fetch models
Route::get('fetch/models','Admin\ModelController@fetchModels');
//terms and condotions
Route::get('admin/terms-conditions','HomeController@getTerms')->name('admin.terms');
Route::post('admin/terms/save','HomeController@saveTerms')->name('save.terms');
//additional package section
Route::get('admin/additional-information','HomeController@getAdditionalInfo')->name('admin.additional-information');
Route::post('admin/additional-info/save','HomeController@saveAdditionalInfo')->name('save.additional.info');
//about us 
Route::get('admin/about-us/main-content','Admin\AboutPageController@listmainContent')->name('admin.about-us.main-content');
Route::post('admin/about-us/main-content/update','Admin\AboutPageController@updateMainContent')->name('admin.about-us.main-content.update');
//meet our team
Route::get('admin/about-us/teams','Admin\AboutPageController@listTeams')->name('admin.about-us.team');
Route::get('admin/about-us/teams/add','Admin\AboutPageController@addTeam')->name('admin.about-us.teams.add');
Route::post('admin/about-us/teams/save','Admin\AboutPageController@saveTeam')->name('admin.about-us.teams.save');
Route::get('admin/about-us/teams/edit/{id}','Admin\AboutPageController@editTeam')->name('admin.about-us.teams.edit');
Route::post('admin/about-us/teams/update','Admin\AboutPageController@updateTeam')->name('admin.about-us.teams.update');
Route::get('admin/about-us/teams/delete/{id}','Admin\AboutPageController@deleteTeam')->name('admin.about-us.teams.delete');
//clients
Route::get('admin/about-us/clients','Admin\AboutPageController@listClients')->name('admin.about-us.clients');
Route::get('admin/about-us/clients/add','Admin\AboutPageController@addClients')->name('admin.about-us.client.add');
Route::post('admin/about-us/clients/save','Admin\AboutPageController@saveClient')->name('admin.about-us.clients.save');
Route::get('admin/about-us/client/edit/{id}','Admin\AboutPageController@editClient')->name('admin.about-us.clients.edit');
Route::post('admin/about-us/client/update','Admin\AboutPageController@updateClient')->name('admin.about-us.client.update');
Route::get('admin/about-us/client/delete/{id}','Admin\AboutPageController@deleteClient')->name('admin.about-us.client.delete');
//services
Route::get('admin/services','Admin\ServiceController@listServices')->name('admin.services');
Route::get('admin/services/add','Admin\ServiceController@addService')->name('admin.service.add');
Route::post('admin/services/save','Admin\ServiceController@saveService')->name('admin.services.save');
Route::get('admin/service/edit/{id}','Admin\ServiceController@editService')->name('admin.services.edit');
Route::post('admin/services/update','Admin\ServiceController@updateService')->name('admin.services.update');
Route::get('admin/service/delete/{id}','Admin\ServiceController@deleteService')->name('admin.services.delete');
//service banner 
Route::get('admin/service/banner','Admin\ServiceController@fetchBanner')->name('admin.services.banner');
//offers
Route::get('admin/offers','Admin\OfferController@listOffers')->name('admin.offers');
Route::get('admin/offers/add','Admin\OfferController@addOffers')->name('admin.offer.add');
Route::post('admin/offers/save','Admin\OfferController@saveOffer')->name('admin.offer.save');
Route::get('admin/offers/edit/{id}','Admin\OfferController@editOffer')->name('admin.offer.edit');
Route::post('admin/offers/update','Admin\OfferController@updateOffer')->name('admin.offers.update');
Route::get('admin/offers/delete/{id}','Admin\OfferController@deleteOffer')->name('admin.offers.delete');
//offers banner
Route::get('admin/offers/banner','Admin\OfferController@fetchBanner')->name('admin.offers.banner');
//careers
Route::get('admin/jobs','Admin\CareerController@listJobs')->name('admin.jobs.list');
Route::get('admin/jobs/add','Admin\CareerController@addJob')->name('admin.jobs.add');
Route::post('admin/jobs/add','Admin\CareerController@saveJob')->name('admin.career.save');
Route::get('admin/career/edit/{id}','Admin\CareerController@editJob')->name('admin.career.edit');
Route::post('admin/jobs/update','Admin\CareerController@updateJob')->name('admin.career.update');
Route::get('admin/career/delete/{id}','Admin\CareerController@deleteJob')->name('admin.career.delete'); 
//career enquiry
Route::get('admin/career/enquiry','Admin\CareerController@listEnquiry')->name('admin.career.enquiry');
Route::get('admin/career/enquiry/delete/{id}','Admin\CareerController@deleteEnquiry')->name('admin.career.enquiry.delete');

//jobs banner
Route::get('admin/jobs/banner','Admin\CareerController@fetchBanner')->name('admin.jobs.banner');

//job category
Route::get('admin/job-category','Admin\CareerController@listCategory')->name('admin.job-category.list');
Route::get('admin/job-category/add','Admin\CareerController@addCategory')->name('admin.job-category.add');
Route::post('admin/job-category/save','Admin\CareerController@saveCategory')->name('admin.job-category.save');
Route::get('admin/job-category/edit/{id}','Admin\CareerController@editJobCategory')->name('admin.job-category.edit');
Route::post('admin/job-category/update','Admin\CareerController@updateCategory')->name('admin.job-category.update');
Route::get('admin/job-category/delete/{id}','Admin\CareerController@deleteCategory')->name('admin.job-category.delete'); 


//contact us
Route::get('admin/contact-us','Admin\ContactController@getContactInfo')->name('admin.contact-us');
Route::post('admin/contact-us/update','Admin\ContactController@updateContactInfo')->name('admin.contact-us.update');
//faqs
Route::get('admin/faqs','Admin\FaqController@listFaqs')->name('admin.faq');
Route::get('admin/faqs/add','Admin\FaqController@addFaq')->name('admin.faq.add');
Route::post('admin/faqs/save','Admin\FaqController@saveFaq')->name('admin.faq.save');
Route::get('admin/faq/edit/{id}','Admin\FaqController@editFaq')->name('admin.faq.edit');
Route::post('admin/faq/update','Admin\FaqController@updateFaq')->name('admin.faq.update');
Route::get('admin/faq/delete/{id}','Admin\FaqController@deleteFaq')->name('admin.faq.delete');
//FAQ BANNER
Route::get('admin/faqs/banner','Admin\FaqController@fetchBanner')->name('admin.faq.banner');
//terms and conditions main
Route::get('admin/terms-and-conditions','Admin\SettingsController@listTerms')->name('admin.terms-and-conditions');
Route::post('admin/page-data/update','Admin\SettingsController@updateData')->name('admin.page-data.update');
//process & package
Route::get('admin/process-and-package','Admin\SettingsController@listProcess')->name('admin.process-and-packages');
//requirements
Route::get('admin/requirements','Admin\SettingsController@listRequirements')->name('admin.requirements');
//car for sale
Route::get('admin/car-for-sale','Admin\SettingsController@listSaleCars')->name('admin.car-for-sale');
//long term rental
Route::get('admin/long-term-rental','Admin\SettingsController@listTermReNTALS')->name('admin.long-term-rental');
//short term rental
Route::get('admin/short-term-rental','Admin\SettingsController@shortTermRentel')->name('admin.short-term-rental');
//lease to own 
Route::get('admin/lease-to-own','Admin\SettingsController@listLease')->name('admin.lease-to-own');
//enquiry contact
Route::get('admin/contact/enquiry','Admin\ContactController@listEnquiry')->name('admin.contact.enquiry');
Route::get('admin/contact/enquiry/delete/{id}','Admin\ContactController@deleteEnquiry')->name('admin.contact.enquiry.delete');
//social media link
Route::get('admin/social-media/links','Admin\SettingsController@listSocialIcons')->name('admin.social-media');
Route::post('admin/social-media/links/update','Admin\SettingsController@updateSocialIcons')->name('admin.social-media.update');
//why choose us
Route::get('admin/setings/why-choose-us','Admin\SettingsController@fetchChooseUs')->name('admin.why-choose-us');

//Language Customization
Route::get('/admin/language-customization','Admin\CustomiseLanaguageController@index')->name('admin.customize.language.index');
Route::get('/admin/language-customization/add','Admin\CustomiseLanaguageController@add')->name('admin.customize.language.add');
Route::post('/admin/language-customization/store','Admin\CustomiseLanaguageController@store')->name('admin.customize.language.store');



   Route::get('/chart', 'HomeController@chart');

   //front starts 

 
Route::group(['namespace' => 'Front'],function(){
  Route::get('web-main-list','HomeController@webCarsist');
  //Route::get('sms-test','Auth\RegisterController@test');
  
    Route::get('/','HomeController@index')->name('web.index');
     Route::get('/car-rental','HomeController@carRentalPage')->name('app.index');
 Route::get('user-login','Auth\LoginController@showLoginForm')->name('user.login');
  Route::post('user-login','Auth\LoginController@usrlogin');
  Route::post('user/logout','Auth\LoginController@logout')->name('user.logout');
  Route::post('user/logout-web','Auth\LoginController@logout2')->name('user.logout2');
 Route::get('user-register','Auth\RegisterController@showRegistrationForm')->name('user.register');
 Route::post('user-register','Auth\RegisterController@create')->name('user.save');
 Route::get('user-otp-verify/{id}','Auth\RegisterController@otpVerify')->name('user.otp.verify');
 Route::post('check-otp','Auth\RegisterController@checkOtp')->name('check.otp');
 Route::get('resend/otp/{id}','Auth\RegisterController@resendOtp')->name('resend.otp');
 //webpages
 Route::get('about-us','WebPageController@aboutPage')->name('about-us');
 Route::get('services','WebPageController@servicePage')->name('services');
 Route::get('offers','WebPageController@offerPage')->name('offers');
 Route::post('contacts/enquiry/save','HomeController@saveContactEnquiry')->name('contact-enquiry-save');
 Route::get('faqs','WebPageController@listFaqs')->name('faqs');
 Route::get('terms-and-conditions','WebPageController@listTerms')->name('terms-and-conditions');
 Route::get('our-process-and-packages','WebPageController@listPackage')->name('our-process-and-packages');
 Route::get('requirements','WebPageController@listRequirements')->name('requirements');
 Route::get('car-for-sale','WebPageController@listCarfSale')->name('car-for-sale');
 Route::get('limousine-and-chaufeer-services','WebPageController@limousineAndChaufeerServices')->name('limousine-and-chaufeer-services');
 Route::get('service-and-maintenance','WebPageController@serviceAndMaintenance')->name('service-and-maintenance');
 Route::get('list-long-term','WebPageController@listLongTerm')->name('long-term-car-rental');
 Route::get('list-short-term','WebPageController@listShortTerm')->name('short-term-car-rental');
 Route::get('lease-to-own','WebPageController@listLeaseToOwn')->name('lease-to-own');
 Route::get('services/{id}','WebPageController@fetchService')->name('service.single');
 
 //gallery 
 Route::get('gallery','GalleryController@albums')->name('gallery.albums');
 Route::get('gallery/{id}/photos','GalleryController@photos')->name('gallery.photos');
 
 //careers
 Route::get('careers','WebPageController@careerPage')->name('careers');
 Route::post('career/quick-enquiry/save','WebPageController@quickEnquirySave')->name('career.quick-enquiry.save');
 Route::get('career/detail/{id}','WebPageController@careerDetail')->name('career.detail');

 //newsletter
 Route::post('newsletter/mail/send','HomeController@newsletterSend')->name('newsletter-send');
 
 //forgot password
 
 Route::get('customer/reset-password','Auth\RegisterController@resetPasswordView')->name('customer.reset.password');
 Route::get('customer/reset-password/mobile-verify','Auth\RegisterController@verifyMobile')->name('customer.password-reset.verify-mobile');
 Route::get('customer/reset-password/verify-otp','Auth\RegisterController@custVerifyOtp')->name('customer.forgot-password.verify.otp');
 Route::get('customer/reset-password/confirm/{id}','Auth\RegisterController@custResetconfirm')->name('customer.password-reset.confirm');
 Route::any('customer/reset-password/update','Auth\RegisterController@updatePass')->name('customer.password-reset.update');
 
 
 
 

 Route::get('user/account','HomeController@account')->name('user.account');
 Route::get('user/profile','ProfileController@getUserProfile')->name('user.profile');
 Route::post('user/profile/update','ProfileController@userProfileUpdate')->name('user.profile.update');
 Route::get('user/change-password','ProfileController@userChangePassword')->name('user.change.password');
 Route::post('user/change-password','ProfileController@userUpdatePassword');
 Route::get('user/feedback','UserFeedbackController@feedback')->name('user.feedback');
 Route::post('user/feedback','UserFeedbackController@saveFeedback');
 Route::get('car/rental','CarController@carList')->name('car.rental');
 Route::get('car/search','CarController@searchCar')->name('car.search');
 Route::get('car/search/vtype/{id}','CarController@searchCar');
 Route::get('car/search/mktype/{id}','CarController@searchCarByBrand');
 Route::get('car/search/sort/{sort}','CarController@sortCar');
 
 Route::get('car/search/change-currency/{id}','CarController@changeCurrency');
 Route::get('get-location-list','CarController@getLocation');
 Route::get('get-location-list-profile','CarController@getLocationProfile');
 Route::get('car/detail/{id}','CarController@carDetail');
 Route::any('user/personal/info','CarController@getPersonalInfo')->name('user.personal.info');
 Route::get('apply-coupon','CarController@applyCoupon')->name('user.personal.applycoupon');
 Route::get('remove-coupon','CarController@removeCoupon')->name('user.personal.removecoupon');
 Route::any('user/personal/info/save','CarController@userInfoSave')->name('user.personal.info.save');
 Route::any('user/personal/info/update','CarController@userInfoEdit')->name('user.personal.info.edit');
 Route::post('user/booking/save','CarController@bookingSave')->name('user.booking.save');
 Route::post('user/booking/update','CarController@bookingUpdate')->name('user.booking.update');
 Route::get('booking-success','CarController@bookingSuccess')->name('booking-success');
  Route::get('get-model-rate','UserHistoryController@getModelRate2')->name('booking.edit.modelrate');
 
 //payment
 Route::get('payment/order_cancel/{id}','CarController@orderCancel');
 Route::get('user/traffic/violation','UserTrafficController@getTrafiicViolation')->name('user.traffic.violation');
 Route::get('user/rental/history','UserHistoryController@getRentalHistory')->name('user.rental.history');
 Route::post('user/car/book','CarController@bookAgain')->name('user.car.book2');
  Route::any('user/car/book-edit','CarController@bookEdit')->name('user.car.bookedit');
 Route::get('user/notifications','NotificationController@getNotifications')->name('user.notifications');
 Route::get('user/reservations','UserHistoryController@getReservations')->name('user.reservations');
 Route::get('user/cancel/booking/{id}','UserHistoryController@cancelBooking')->name('user.cancel.booking');
Route::get('contact-us','HomeController@contactPage')->name('contact-us');
//email unique
	Route::get('check-email','HomeController@checkEmail');
//mobile unique
	Route::get('check-mobile','HomeController@checkMobile');
	Route::any('test','CarController@payment');


 });

