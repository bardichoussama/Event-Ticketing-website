
<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');



// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });

// require __DIR__.'/auth.php';

