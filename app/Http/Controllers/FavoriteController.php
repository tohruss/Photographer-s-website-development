<?php

namespace App\Http\Controllers;

use App\Models\FavoriteService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $favoriteServices = FavoriteService::with('service')
            ->where('user_id', $user->id)
            ->get();

        $services = $favoriteServices->map(function ($item) {
            return $item->service;
        })->filter();

        return view('favorites', compact('services'));
    }


    public function addToFavorites(Request $request, $serviceId)
    {
        $user = Auth::user();
        $service = Service::findOrFail($serviceId);

        $exists = FavoriteService::where('user_id', $user->id)
            ->where('service_id', $service->id)
            ->exists();

        if (!$exists) {
            FavoriteService::create([
                'user_id' => $user->id,
                'service_id' => $service->id,
            ]);
        }

        return redirect()->back()->with('success', 'Услуга добавлена в избранное!');
    }


    public function removeFromFavorites(Request $request, $serviceId)
    {
        $user = Auth::user();
        $service = Service::findOrFail($serviceId);

        FavoriteService::where('user_id', $user->id)
            ->where('service_id', $service->id)
            ->delete();

        return redirect()->back()->with('success', 'Услуга удалена из избранного!');
    }
}
