<?php

use Illuminate\Http\Request;


Route::get('/getNooProperty/{id}/{index}','MatchController@getNooProperty');
Route::post('/yesVote','MatchController@yesVote');
Route::get('/match-property-by-id/{id}','MatchController@MatchPropertyByID');
Route::get('/update-vote/{id}/{type}','MatchController@UpdateVote');
Route::get('/update-vote/{id}/{type}','MatchController@UpdateVote');
Route::get('/getMasterProperty/{id}','MatchController@MasterProperty');
Route::get('/reverseImageResult','MatchController@getReverseImageResult');
Route::get('/host-information/{id}','HostController@hostInformation');
