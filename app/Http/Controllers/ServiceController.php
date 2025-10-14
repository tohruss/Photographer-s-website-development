<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\CategoryOfService;
use App\Http\Requests\ServiceRequest;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ServiceController extends Controller
{

    public function index()
    {
        $categories = CategoryOfService::with([
            'service' => fn($query) => $query->with('user:id,login')
        ])->get(['id', 'name']);

        return view('service', [
            'categories' => $categories,
            'user' => auth()->user(),
        ]);
    }

}


