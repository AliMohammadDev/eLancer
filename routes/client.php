<?php

use App\Http\Controllers\Client\ProjectsController;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'clients',
    'as' => 'client.',
    'middleware'=>['auth'],
], function () {
    Route::resource('projects', ProjectsController::class);
});
