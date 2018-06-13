<?php

Route::middleware(['api', 'cors'])->resource('agencms/pages', 'Agencms\Pages\Controllers\PageController');
