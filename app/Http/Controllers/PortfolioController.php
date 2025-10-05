<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImagesRequest;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $portfolioItems = Portfolio::all(['id', 'photo'])
            ->map(function ($item) {
                $item->photo_url = Storage::url($item->photo);
                return $item;
            });

        return view('portfolio', compact('portfolioItems'));
    }

    public function store(UploadImagesRequest $request): RedirectResponse
    {
        foreach ($request->file('images') as $image) {
            $path = $image->store('portfolio', 'public');

            Portfolio::create([
                'user_id' => auth()->id(),
                'photo' => $path,
            ]);
        }

        return redirect()->route('portfolio')
            ->with('success', 'Изображения успешно добавлены в портфолио.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $item = Portfolio::findOrFail($id);

        if (Storage::disk('public')->exists($item->photo)) {
            Storage::disk('public')->delete($item->photo);
        }

        $item->delete();

        return redirect()->route('portfolio')
            ->with('success', 'Изображение удалено из портфолио.');
    }
}
