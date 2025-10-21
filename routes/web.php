<?php

use App\Http\Controllers\FavoriteController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UserInfoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// Запрос ссылки на сброс
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

// Форма нового пароля
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Обработка сброса
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');


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
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Ссылка для подтверждения отправлена!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/', function () { return view('welcome');})->name('welcome');
Route::get('/registration', [UserInfoController::class, 'showRegistrationForm'])->name('registration');
Route::get('/login', [UserInfoController::class, 'showLoginForm'])->name('login');
Route::post('/registration', [UserInfoController::class, 'register'])->name('registration');
Route::post('/login', [UserInfoController::class, 'login'])->name('login.submit');
Route::post('/logout', [UserInfoController::class, 'logout'])->name('logout');


Route::middleware(['auth','verified'])->group(function () {
    Route::get('/studios', function () {return view('studios');})->name('studios');
    Route::get('/contacts', function () {return view('contacts');})->name('contacts');
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
    Route::get('/reviews', [ReviewController::class, 'reviews'])->name('reviews');
    Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment');
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::get('/profile', [UserInfoController::class, 'showProfile'])->name('profile');
    Route::get('/profile/edit', [UserInfoController::class, 'showEditForm'])->name('profile.edit');
    Route::put('/profile', [UserInfoController::class, 'updateProfile'])->name('profile.update');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorites/{serviceId}', [FavoriteController::class, 'addToFavorites'])->name('favorites.add');
    Route::delete('/favorites/{serviceId}', [FavoriteController::class, 'removeFromFavorites'])->name('favorites.remove');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::post('/equipment', [EquipmentController::class, 'store']);
    Route::get('/equipment/{id}/edit', [EquipmentController::class, 'edit'])->name('equipment-edit');
    Route::put('/admin/equipment/{id}', [EquipmentController::class, 'update'])->name('admin.equipment.update');
    Route::delete('/equipment/{id}', [EquipmentController::class, 'destroy']);

    Route::post('/portfolio', [PortfolioController::class, 'store'])->name('admin.portfolio.store');
    Route::delete('/portfolio/{id}', [PortfolioController::class, 'destroy'])->name('admin.portfolio.destroy');

    Route::post('/equipment/categories', [EquipmentController::class, 'createCategory']);
    Route::get('/equipment/categories/{id}/edit', [EquipmentController::class, 'editCategory'])->name('admin.equipment.category.edit');
    Route::put('/equipment/categories/{id}', [EquipmentController::class, 'updateCategory'])->name('admin.equipment.category.update');
    Route::delete('/equipment/categories/{id}', [EquipmentController::class, 'deleteCategory'])->name('admin.equipment.delete-category');

    Route::post('/services', [ServiceController::class, 'store']);
    Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('service-edit');
    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('admin.service.update');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    Route::post('/services/categories', [ServiceController::class, 'createCategory']);
    Route::get('/services/categories/{id}/edit', [ServiceController::class, 'editCategory'])->name('admin.service.category.edit');
    Route::put('/services/categories/{id}', [ServiceController::class, 'updateCategory'])->name('admin.service.category.update');
    Route::delete('/services/categories/{id}', [ServiceController::class, 'deleteCategory'])->name('admin.service.delete-category');
});
