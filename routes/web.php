<?php


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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::post('/registerFcmToken', 'HomeController@registerFcmToken');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/datafiniti-import', 'ImportController@index');
Route::post('/import', 'ImportController@import');
Route::get('/noo-property-import', 'ImportController@propertyImport');
Route::post('/noo-property-import', 'ImportController@savepropertyImport');
Route::post('/import-property', 'ImportController@propertyImport')->name('import.property');
Route::post('/file-upload', 'ImportController@uploadFile')->name('file.upload');
Route::get('/datafiniti-property-list', 'ImportController@importHistory');
Route::get('/datafiniti-property-details/{id}', 'ImportController@importHistoryDetails');
Route::get('/datafiniti-property-edit/{id}','ImportController@editRental');
Route::post('/edit-rental','ImportController@updateRental');
Route::get('/noo-property-list','ImportController@propertiesHistory');
Route::get('/noo-property-details/{id}','ImportController@propertyDetails')->name('property.detail');
Route::get('/noo-property-edit/{id}','ImportController@propertyEdit');
Route::post('/property-edit','ImportController@updateProperty');
Route::get('/rental-edit','ImportController@inlineRentalEdit')->name('inline.rental.edit');
Route::get('/inline-property-edit','ImportController@inlinePropertylEdit')->name('inline.property.edit');


Route::get('/region/list', 'ApiController@regionList')->name('region.list');
Route::get('/region/details', 'ApiController@regionDetails')->name('region.details');
Route::get('/region/listings', 'ApiController@regionListing')->name('region.listings');
Route::get('/listing/details', 'ApiController@regionListingDetails')->name('region.details');
Route::get('/listing/images', 'ApiController@listingImages')->name('listings.images');
Route::get('/listing/thumbnails', 'ApiController@listingThumbnails')->name('listings.thumbnails');
Route::get('/listing/image', 'ApiController@listingImage')->name('listings.image');
Route::get('/listing/reviews', 'ApiController@listingReviews')->name('listings.review');
Route::get('/listing/screenshots', 'ApiController@listingScreenshots')->name('listings.screenshots');
Route::get('/listing/screenshot', 'ApiController@listingScreenshot')->name('listings.screenshot');
//Route::get('/host/details', 'ApiController@hostDetails')->name('host.details');
Route::get('/host/guestreviews', 'ApiController@hostGuestReviews')->name('host.guestreviews');
Route::get('/leaseabuse-property-list', 'ApiController@regionHistory')->name('region.history');
Route::get('/leaseabuse-property-details/{id}', 'ApiController@regionDetails')->name('region.details');
Route::get('/inline-region-edit','ApiController@inlineRegionEdit')->name('inline.region.edit');
Route::get('/leaseabuse-region-list', 'ApiController@region')->name('regions');
Route::get('/noo-property-map','ApiController@PropertyMap')->name('property.map');
Route::get('/master-property','PropertyController@index')->name('master.property');
Route::get('/combine-data','PropertyController@CombineData')->name('combine.data');
Route::get('/edit-master-property/{id}','PropertyController@EditMasterProperty')->name('edit.master.property');
Route::post('/update-master-property','PropertyController@UpdateMasterProperty')->name('update.master.property');
Route::get('/master-property-details/{id}','PropertyController@MasterPropertyDetails')->name('master.property.details');
Route::get('/master-property-map','PropertyController@MasterPropertyMap')->name('master.property.map');
Route::get('/image-object','PropertyController@imageObject')->name('image.object');
Route::post('/upload-custom-image','ApiController@UploadCustomeImage');
Route::get('/datafiniti-image','PropertyController@DatafinitiImage');
Route::get('/leaseabuse-property-image','PropertyController@leaseabusePropertyImage');
Route::get('/job-in-queue','QueueController@index')->name('queue');
Route::post('/upload-file','QueueController@uploadFile')->name('upload.file');
Route::post('/upload-file','QueueController@uploadFile')->name('upload.file');
Route::get('/destroy-job-in-queue/{id}','QueueController@destroyUploadFile')->name('destroy.job-in-queue');
Route::get('/active-Job/{id}','QueueController@jobActive')->name('job.active');
Route::get('/export-noo-property-picture','PropertyController@ExportPicture')->name('export.noo.picture');
Route::post('/import-noo-property-picture','PropertyController@ImportPicture')->name('import.noo.picture');
Route::get('/rental-property/match-map/{id}','PropertyController@matchMapProperty')->name('match.map.property');
Route::get('/rental-property/match/{id}','PropertyController@matchProperty')->name('match.property');
Route::get('/rental-property/detach/{id}','PropertyController@matchDetachProperty')->name('match.detach.property');
Route::get('/rental-property-map','PropertyController@rentalPropertyMap')->name('rental.property.map');
Route::post('/export-noo-details','PropertyController@ExportNooDetails')->name('export.noo.details');
Route::get('/master-property-view/{id}','PropertyController@MasterPropertyView')->name('master.property.view');
Route::get('/user-list','UserController@UserList')->name('user.list');
Route::get('/users/create','UserController@create')->name('users.create');
Route::post('/users','UserController@store')->name('users.store');
Route::get('/users/{id}','UserController@edit')->name('users.edit');
Route::put('/users/{id}','UserController@update')->name('users.update');
Route::delete('/users/{id}','UserController@destroy')->name('users.destroy');
Route::get('/user-details/{id}','UserController@UserDetails')->name('user.details');
Route::get('/change-vote/{id}','UserController@ChangeVote')->name('change.vote');
Route::get('/user-property-map/{id}','UserController@UserPropertyMap');
Route::post('/assign-user-community','UserController@AssignUserCommunity')->name('assign.community');
Route::get('/noo-property-data','MatchController@NooPropertyData');
Route::get('/host-list','HostController@hostList')->name('host.list');
Route::get('/host-details/{id}','HostController@hostDetails')->name('host.details');
Route::get('/noo-property-owner','OwnerController@index')->name('noo.property.owner');
Route::get('/noo-property-owner/{id}','OwnerController@show')->name('noo.property.owner.show');
Route::get('/analytic-view','PropertyController@getAnalyticalView');
Route::get('/line-graph','PropertyController@matchPropertyLineGraph');
Route::get('/export-community-csv','PropertyController@exportCommunityCSV')->name('export.community');
Route::post('/export-community-csv','PropertyController@exportCommunityCSV')->name('export.community');
Route::post('/save-manual-match','HostController@saveManualMatch')->name('save.manual.match');
Route::get('/destroy-manual-match/{id}','HostController@destroyManualMatch')->name('destroy.manual.match');
Route::post('/update-host-image-url','HostController@updateImageUrl')->name('update.host.image_url');

// Ajax Routes

Route::get('/get-vision-result/{masterPropertyId}', 'MatchController@getVisionResult')
        ->name('getVisionResult');

Route::get('/search-noo-property', 'MatchController@searchNOOPropertyByStreet')
        ->name('searchNOOPropertyByStreet');
