
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestReservation;

Route::get('/reservations/index', [TestReservation::class, 'index']);

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');




// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });

// require __DIR__.'/auth.php';

