<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UserInfoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ServiceController;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect('/profile');
    }

    \Log::info('Попытка отправки письма подтверждения для пользователя: ' . $request->user()->email);

    $request->user()->sendEmailVerificationNotification();

    \Log::info('Письмо подтверждения отправлено');

    return back()->with('message', 'Ссылка для подтверждения отправлена!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/', function () { return view('welcome');})->name('welcome');
Route::get('/registration', [UserInfoController::class, 'showRegistrationForm'])->name('registration');
Route::get('/login', [UserInfoController::class, 'showLoginForm'])->name('login');
Route::post('/registration', [UserInfoController::class, 'register'])->name('registration');
Route::post('/login', [UserInfoController::class, 'login'])->name('login.submit');
Route::post('/logout', [UserInfoController::class, 'logout'])->name('logout');
Route::get('/favorites', [UserInfoController::class, 'favorites'])->name('favorites');

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/studios', function () {return view('studios');})->name('studios');
    Route::get('/contacts', function () {return view('contacts');})->name('contacts');
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
    Route::get('/reviews', [ReviewController::class, 'reviews'])->name('reviews');
    Route::get('/equipment', [EquipmentController::class, 'equipment'])->name('equipment');
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::get('/profile', [UserInfoController::class, 'showProfile'])->name('profile');
    Route::get('/profile/edit', [UserInfoController::class, 'showEditForm'])->name('profile.edit');
    Route::put('/profile', [UserInfoController::class, 'updateProfile'])->name('profile.update');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::post('/equipment', [EquipmentController::class, 'store']);
    Route::put('/equipment/{id}', [EquipmentController::class, 'update']);
    Route::delete('/equipment/{id}', [EquipmentController::class, 'destroy']);

    Route::post('/portfolio', [PortfolioController::class, 'store'])->name('admin.portfolio.store');
    Route::delete('/portfolio/{id}', [PortfolioController::class, 'destroy'])->name('admin.portfolio.destroy');

    Route::post('/equipment/categories', [EquipmentController::class, 'createCategory']);
    Route::put('/equipment/categories/{id}', [EquipmentController::class, 'updateCategory']);
    Route::delete('/equipment/categories/{id}', [EquipmentController::class, 'deleteCategory']);

    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    Route::post('/services/categories', [ServiceController::class, 'createCategory']);
    Route::put('/services/categories/{id}', [ServiceController::class, 'updateCategory']);
    Route::delete('/services/categories/{id}', [ServiceController::class, 'deleteCategory']);
});
