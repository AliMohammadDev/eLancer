<?php

use App\Http\Controllers\ProfileController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $categories = Category::all();

    return view('home', [
        'categories' => $categories,
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:admin,web'])->name('dashboard');

// Route::middleware('auth')->group(function (): void {
//   Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//   Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//   Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

Route::group([
    'prefix' => 'admin',
    'as' => 'admin',
], function () {
    require __DIR__.'/auth.php';
});
require __DIR__.'/dashboard.php';
require __DIR__.'/freelancer.php';
require __DIR__.'/client.php';
