<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin', 'prefix' => 'adminpanel'], static function (): void {
    Route::get('/groups', 'AdminPanelController@index');

    Route::put('/set-autogroups', 'AdminPanelController@setAutoGroups');
    Route::put('/update-autogroups', 'AdminPanelController@updateAutoGroups');
});
