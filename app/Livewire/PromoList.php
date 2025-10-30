<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Promocode;
use Illuminate\Support\Facades\Auth;

class PromoList extends Component
{

    public function deactivate($id)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $promo = Promocode::findOrFail($id);
        $promo->update(['is_active' => false]);

        $this->dispatch('promocodeDeactivated');
    }

    public function render()
    {
        $promocodes = Promocode::where('is_active', true)->get();
        return view('livewire.promo-list', compact('promocodes'));
    }
}
