<?php
use YSITD\Http\Controllers\ApiController;

Route::group(['middleware' => ['api_auth', 'req_user']], function() {
    // Random question
    Route::get('/api/random_question', ['uses' => 'ApiController@random_question']);
    
    // Post answer
    Route::post('/api/post_answer', ['uses' => 'ApiController@post_answer']);
    
    // Get user status
    Route::get('/api/user_status', ['uses' => 'ApiController@user_status']);
    
    // Update user status
    Route::post('/api/user_status', ['uses' => 'ApiController@post_user_status']);
});