<?php

use Agencms\Settings\Settings;

if (Settings::get('global', 'homepage')) {
    Route::get('/', 'Agencms\Pages\Controllers\PageController@homepage')->name('home');
}

Route::get('p/{page}', 'Agencms\Pages\Controllers\PageController@render')->name('page');
