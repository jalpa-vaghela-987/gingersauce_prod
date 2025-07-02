<?php
Route::get('bookdata/{id}', function($id){
    return \App\Brandbook::find($id);
})->middleware('admin.user');



//Route::any( 'testing', 'TestController@index' );
//Route::get('4666pull', function(){ return \App\Brandbook::find(4666);  });
Route::group( [ 'middleware' => [ 'locale' ] ], function () {

    Route::get( 'set_locale/{lang}', 'LocaleController@index' )->name( 'setLocale' );

    // Route::get('/invo', function(){
    // 	return view('pdf.invoice')->with(['invoice'=>App\Invoice::first()]);
    // });

    // Route::get('/email', function(){
    // 	return (new App\Mail\ShareByEmailNotification(Auth::user(), App\Brandbook::first(), 'https://google.com'))->render();
    // });

    Route::get( '/pdf/gen/{id}', 'BrandbookController@generate_pdf' )->name( 'brandbook.pdf' );
    Route::get( '/shared/{link}', 'BrandbookController@shared' )->name( 'brandbook.shared' );
    Route::get( '/embed/{link}', 'BrandbookController@embed' )->name( 'brandbook.embed' );
    Route::get( '/embed_view/{link}', 'BrandbookController@embed_view' )->name( 'brandbook.embed.view' );

    Route::get( '/invite/{link}', 'ReferController@invite' )->name( 'user.invite' );

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

    Route::get( '/', function () {

        return view( 'auth.login' );
    } );

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::get( '/features', function () {

        return view( 'static.features' );
    } )->name( 'features' );
    Route::get( '/pricing', function () {

        return view( 'static.pricing' )->with( [ 'packages' => App\Package::where( 'language', Config::get( 'app.locale' ) )->orderBy( 'position', 'asc' )->get() ] );
    } )->name( 'pricing' );
    Route::get( '/customers', function () {

        return view( 'static.customers' );
    } )->name( 'customers' );
    Route::get( '/privacy-policy', function () {

        return view( 'static.customers' );
    } )->name( 'privacy-policy' );
    Route::get( '/terms-of-use', function () {

        return view( 'static.customers' );
    } )->name( 'terms-of-use' );

    Route::get( 'packages', 'PackageController@packages' );


    Auth::routes();
    //Route::get('/home', 'HomeController@index')->name('home');
    Route::get( '/pdf-preview/{brandbook}', 'BrandbookController@pdf_preview' )->name( 'pdf_preview' );
    Route::get( '/remove-watermark/{book_id}', 'BrandbookController@removeWatermarkAfterPayment' )->middleware( 'auth' )->name( 'remove_after_payment' );


    Route::get( '/social/{provider}', 'SocialLoginController@callback' )->name( 'social.callback' );
    Route::get( '/auth/{provider}', 'SocialLoginController@redirect' )->name( 'social.redirect' );

    Route::group( [ 'prefix' => 'feedback', 'middleware' => 'auth' ], function () {
        Route::post( 'create', 'FeedbackController@store' )->name( 'store_feedback' );
    } );

    Route::group( [ 'prefix' => 'my' ], function () {
        Route::get( '/separate-logo/{brandbook}/{type?}', 'BrandbookController@separateLogoDownload' )->name( 'brandbook.separate.logo' );
        Route::get( '/logo/{brandbook}', 'BrandbookController@logo_download' )->name( 'brandbook.logo' );
        Route::get( '/pdf/{brandbook}', 'BrandbookController@pdf_download' )->name( 'brandbook.pdf' );
        Route::get( '/new-view-page/{brandbook}', 'BrandbookController@newViewPage' )->name( 'brandbook.new.view.page' );
        Route::get( '/new-view-brandbook-v3-page/{brandbook}', 'BrandbookController@newViewBrandBookV3Page' )->name( 'brandbook.v3.new.view.page' );
        Route::get( '/tabs/{brandbook}', 'TabController@tabs')->name('tabs');
        Route::get( '/tab-contents/{tab}', 'TabContentController@tabContents')->name('tab.contents');
        Route::get( '/{vue_capture?}', 'BrandbookController@my' )->where( 'vue_capture', '[\/\w\.-]*' )->name( 'brandbook.my' );
        Route::delete( '/delete/{brandbook}', 'BrandbookController@delete' )->name( 'brandbook.delete' );
        Route::put( '/duplicate/{brandbook}', 'BrandbookController@duplicate' )->name( 'brandbook.duplicate' );
        Route::put( '/tabs/update-order', 'TabController@updateTabsOrder');//keep this route here only
        Route::resource( '/tabs', 'TabController');
        Route::delete('delete-tab/{tab}','TabController@deleteTab');
        Route::resource( '/tab-contents', 'TabContentController');
    } );

    Route::group( [ 'prefix' => 'profile', 'middleware' => 'auth' ], function () {

        Route::get( '/', 'ProfileController@index' )->name( 'profile.my' );
        Route::get( '/start', 'ProfileController@start' )->name( 'profile.start' );
        Route::get( '/plans-pricing', 'ProfileController@plans_pricing' )->name( 'profile.plans-pricing' );
        Route::get( '/plans', 'ProfileController@plans' )->name( 'profile.plans-pricing' )->middleware( 'auth' );
        Route::post( '/save', 'ProfileController@save' )->name( 'profile.save' );
        Route::post( '/upload_avatar', 'ProfileController@upload_avatar' )->name( 'profile.avatar' );
        Route::post( '/upload_logo', 'ProfileController@upload_logo' )->name( 'profile.logo' );
        Route::post( '/upgrade', 'ProfileController@upgrade' )->name( 'profile.upgrade' );

        Route::get( '/plans', 'MyPlansController@index' )->name( 'profile.plans' );
        Route::resource( '/billing', 'BillingController' );
        Route::put( '/make-default/{id}', 'BillingController@make_default' )->name( 'billing.make_default' );
        Route::post( 'update-billing-info', 'BillingController@update_billing_info' )->name( 'billing.info_update' );
        Route::post( 'toggle-reccuring', 'BillingController@toggleReccuring' )->name( 'profile.toggle_reccuting' );
        Route::get( 'get-extends', 'BillingController@extendsGetJSON' )->name( 'profile.get_extends' );
        Route::post( 'book-extend', "BillingController@extendBook" )->name( 'billing.book_extend' );
        Route::get( 'upgrade-packages', "BillingController@packagesUpgrade" )->name( 'upgrade_packages_get' );
    } );

    Route::group( [ 'prefix' => 'invoices', 'middleware' => 'auth' ], function () {

        Route::get( '/', 'InvoiceController@index' )->name( 'invoice.index' );
        Route::post( '/create', 'InvoiceController@create' )->name( 'invoice.create' );
        Route::get( '/{invoice}/pay', 'InvoiceController@pay' )->name( 'invoice.pay' );
        Route::get( '/{invoice}/pdf', 'InvoiceController@pdf' )->name( 'invoice.pdf' );
        Route::get( '/{invoice}/checkout', 'InvoiceController@single' )->name( 'invoice.single' );
        Route::post( '/{invoice}/checkout', 'InvoiceController@checkout' )->name( 'invoice.checkout' );
        Route::get( '/{invoice}/thankyou', 'InvoiceController@thankyou' )->name( 'invoice.thankyou' );
    } );

    Route::group( [ 'prefix' => 'ajax', 'middleware' => 'auth' ], function () {

        Route::group( [ 'prefix' => 'get' ], function () {

            Route::get( 'industries', 'IndustryController@get' )->name( 'ajax.get.industries' );
            Route::get( 'industries/related', 'IndustryController@get_related' )->name( 'ajax.get.industries.related' );

            Route::get( 'themes', 'ThemeController@load' )->name( 'ajax.get.themes' );
            Route::get( 'theme', 'ThemeController@load_preview' )->name( 'ajax.get.theme' );
        } );
        Route::group( [ 'prefix' => 'post' ], function () {

            Route::post( 'brandbook/create', 'BrandbookController@create' )->name( 'ajax.post.brandbook.create' );
            Route::post( 'brandbook/save', 'BrandbookController@save' )->name( 'ajax.post.brandbook.save' );
            Route::post( 'brandbook/save-custom', 'BrandbookController@saveCustom' )->name( 'save_custom' );
            Route::post( 'brandbook/save-customize', 'BrandbookController@saveCustomize' )->name( 'ajax.post.brandbook.save_customize' );
            Route::post( 'brandbook/saveSeparate', 'BrandbookController@saveSeparate' )->name( 'ajax.post.brandbook.saveSeparate' );
            Route::post( 'brandbook/edit', 'BrandbookController@edit' )->name( 'ajax.post.brandbook.edit' );
            Route::post( 'brandbook/save_field', 'BrandbookController@save_field' )->name( 'ajax.post.brandbook.save_field' );
            Route::post( 'brandbook/shares', 'ShareController@load' )->name( 'ajax.post.brandbook.shares' );
            Route::post( 'brandbook/shares/add', 'ShareController@add' )->name( 'ajax.post.brandbook.shares_add' );
            Route::post( 'brandbook/shares/edit', 'ShareController@edit' )->name( 'ajax.post.brandbook.shares_edit' );
            Route::post( 'brandbook/shares/delete', 'ShareController@delete' )->name( 'ajax.post.brandbook.shares_delete' );
            Route::post( 'brandbook/shares/link', 'ShareController@link' )->name( 'ajax.post.brandbook.shares_link' );
            Route::post( 'brandbook/shares/code', 'ShareController@code' )->name( 'ajax.post.brandbook.shares_code' );
            Route::post( 'brandbook/list_item', 'BrandbookController@list_item' )->name( 'ajax.post.brandbook.list_item' );


            Route::post( 'generate_pdf', 'BrandbookController@generate_pdf' )->name( 'ajax.post.brandbook.generate_pdf' );
            Route::post( 'load', 'BrandbookController@load' )->name( 'ajax.post.brandbook.load' );
            Route::post( 'resume', 'BrandbookController@resume' )->name( 'ajax.post.brandbook.resume' );

            Route::post( 'load_embed', 'BrandbookController@load_embed' )->name( 'ajax.post.brandbook.load_embed' );


            Route::post( 'upload_logo', 'BrandbookController@upload_logo' )->name( 'ajax.post.upload_logo' );
            Route::post( 'old_upload_logo', 'BrandbookController@old_upload_logo' )->name( 'ajax.post.old_upload_logo' );
            Route::post( 'upload_icon', 'BrandbookController@upload_icon' )->name( 'ajax.post.upload_icon' );
            Route::post( 'upload_font', 'BrandbookController@upload_font' )->name( 'ajax.post.upload_font' );
            Route::post( 'upload_icon_adv', 'BrandbookController@upload_icon_adv' )->name( 'ajax.post.upload_icon_adv' );
            Route::post( 'upload_mockup', 'BrandbookController@upload_mockup' )->name( 'ajax.post.upload_mockup' );
            Route::post( 'upload_icon_family', 'BrandbookController@upload_icon_family' )->name( 'ajax.post.upload_icon_family');
            Route::post( 'upload_graphic_element', 'BrandbookController@upload_graphic_element' )->name( 'ajax.post.upload_graphic_element');
            Route::post( 'upload_misuse', 'BrandbookController@upload_misuse' )->name( 'ajax.post.upload_misuse' );
            Route::post( 'remove-watermark', 'BrandbookController@removeWatermark' )->name( 'ajax.post.remove_watermark' );

            Route::post( 'referafriend', 'ReferController@refer' )->name( 'ajax.post.referafriend' );

            Route::post( 'coupon', 'CouponController@check' )->name( 'ajax.post.coupon' );

            Route::post( 'load_user', 'InvoiceController@load_user' )->name( 'ajax.post.load_user' );

            Route::post( 'colormind', 'BrandbookController@colormind' )->name( 'ajax.post.colormind' );
        } );
        Route::put( 'brandbook/edit-custom-field/{brandbook}', 'BrandbookController@editCustomField' )->name( 'ajax.brandbook.edit.custom.field' );
    } );
    Route::get('author/dashboard', 'BrandbookController@authorDashboard' )->name( 'author.brandbooks' );
} );


Route::group( [ 'prefix' => 'restricted' ], function () {
    Route::get( '/stats', 'StatsController@index' )->name( 'stats.index' )->middleware( 'admin.user' );
    Route::get( '/stats/weekly', 'WeeklyStatsController@index' )->name( 'stats.weekly' )->middleware( 'admin.user' );
    Route::post( '/invoices/unsubscribe', 'Admin\InvoiceController@unsubscribe' )->name( 'invoice.unsubscribe' )->middleware( 'admin.user' );
    Voyager::routes();
} );


Route::prefix( 'admin' )
    ->name( 'admin.' )
    ->middleware( [ 'admin.user' ] )
    ->group( function () {

        Route::get( 'brandbook-files/{brandbook}', 'BrandbookController@admin_files' )->name( 'brandbook-files' );
        Route::post( 'users/change/credits', 'ProfileController@change_credits' )->name( 'users.change.credits' );
    } );

Route::get('getInfoCenter','TestsController@getInfo');
Route::get('getUserSubscriptionDetail/{user}','TestsController@getUserSubscriptionDetail');
Route::get('getAllBooks/{limit}','TestsController@getAllBrandBooks');
Route::get('getCreditsLog/{date}/{userId?}','TestsController@getCreditsLog');
Route::get('getRecurringBooks/{limit?}','TestsController@getRecurringBooks');
Route::get('updateExpiryDate/{bookId}/{date}','TestsController@updateExpiryDate');
Route::get('getAutoRenewwalOnBooks','TestsController@getAutoRenewwalOnBooks');
Route::get('runAutoRenewwalCommand','TestsController@runAutoRenewwalCommand');
Route::get('readTodayLogFile','TestsController@readTodayLogFile');
Route::get('getFiles/{bookId?}','TestsController@testFiles');
Route::get('/test-smtp', 'TestsController@testSMTP');

