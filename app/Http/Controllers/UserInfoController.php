<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UserInfoRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserInfoController extends Controller
{

    public function showRegistrationForm(): View
    {
        return view('auth.registration');
    }

    public function register(RegisterUserRequest $request): RedirectResponse
    {
        $user = User::create([
            'login' => $request->login,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' =>Role::where('name','user')->first()->id,
        ]);
        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Регистрация прошла успешно! Теперь войдите в аккаунт.');
    }

    public function showLoginForm(): View
    {
        return view('auth.login');
    }
    public function login(): RedirectResponse
    {
        $credentials = request()->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Попытка входа по login или email
        $user = User::where('login', $credentials['login'])
            ->orWhere('email', $credentials['login'])
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Неверный логин или пароль.',
        ]);
    }

    // Выход
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }

    public function showProfile(): View
    {
        $user = auth()->user()->load('userInfo');
        return view('profile.profile', compact('user'));
    }
    public function showEditForm(): View
    {
        $user = auth()->user()->load('userInfo');
        return view('profile.edit', compact('user'));
    }


    public function updateProfile(UserInfoRequest $request): RedirectResponse
    {
        $user = auth()->user();

        // Обновляем основные данные (если переданы)
        $userInfoData = $request->only(['name', 'surname', 'phone']);
        $userInfoData['tel'] = $userInfoData['phone'] ?? null; // если в БД поле 'tel'
        unset($userInfoData['phone']); // убираем лишнее

        // Обработка аватара
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $userInfoData['avatar'] = $path;
        }

        // Создаём или обновляем запись в user_info
        $user->userInfo()->updateOrCreate(
            ['user_id' => $user->id],
            $userInfoData
        );

        return redirect()->route('profile')->with('success', 'Профиль успешно обновлён!');
    }

    // Показ избранного
    public function favorites(): View
    {
        $favorites = auth()->user()->favoriteServices()
            ->get(['id', 'title', 'price', 'description', 'photo']);

        return view('favorites', compact('favorites'));
    }
}
