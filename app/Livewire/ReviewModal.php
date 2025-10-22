<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewModal extends Component
{
    public $showModal = false;
    public $link_to_media = '';
    public $comment = '';
    public $message = ''; // ← для сообщения об успехе

    protected $rules = [
        'comment' => 'required|string',
        'link_to_media' => 'nullable|string',
    ];

    public function openModal()
    {
        $this->reset();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function submit()
    {
        $this->validate();

        Review::create([
            'link_to_media' => $this->link_to_media,
            'comment' => $this->comment,
            'is_approved' => false,
            'user_id' => Auth::id(),
        ]);

        $this->message = 'Ваш отзыв успешно отправлен на модерацию!';
        $this->reset(['link_to_media', 'comment']);
        $this->showModal = false;

        // Опционально: скрыть сообщение через 5 секунд
        $this->dispatch('reviewSubmitted');
    }

    public function render()
    {
        return view('livewire.review-modal');
    }
}
