<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Promocode;
use Illuminate\Support\Facades\Auth;

class AdminPromocodeForm extends Component
{
    use WithFileUploads;
    public $showModal = false;
    public $name = '';
    public $discount = '';
    public $message = '';
    public $image = null;

    protected $rules = [
        'name' => 'required|string|unique:promocodes,name',
        'discount' => 'required|numeric|min:100',
        'image' => 'nullable|image|max:2048',
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

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('promocodes', 'public');
        }

        Promocode::create([
            'name' => strtoupper(trim($this->name)),
            'discount' => $this->discount,
            'is_active' => true,
            'image' => $imagePath,
        ]);

        $this->message = 'Промокод успешно создан!';
        $this->showModal = false;
        $this->reset(['name', 'discount', 'image']);
        $this->dispatch('promocodeCreated');
    }

    public function render()
    {
        return view('livewire.admin-promocode-form');
    }
}
