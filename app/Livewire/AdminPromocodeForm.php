<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Promocode;
use Illuminate\Support\Facades\Auth;

class AdminPromocodeForm extends Component
{
    public $showModal = false;
    public $name = '';
    public $discount = '';
    public $message = '';

    protected $rules = [
        'name' => 'required|string|unique:promocodes,name',
        'discount' => 'required|numeric|min:0',
    ];

    public function openModal()
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }
        $this->reset(['name', 'discount', 'message']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function createPromocode()
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $this->validate();

        Promocode::create([
            'name' => strtoupper(trim($this->name)),
            'discount' => $this->discount,
            'is_active' => true,
        ]);

        $this->message = 'Промокод успешно создан!';
        $this->showModal = false;

        // Опционально: можно отправить событие для обновления списка
        $this->dispatch('promocodeCreated');
    }

    public function render()
    {
        return view('livewire.admin-promocode-form');
    }
}
