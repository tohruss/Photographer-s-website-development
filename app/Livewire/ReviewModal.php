<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;

class ReviewModal extends Component
{
    public $showModal = false;
    public $author_name = '';
    public $link_to_media = '';
    public $comment = '';

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
            'user_id' => auth()->id(),
        ]);

        $this->reset();
        $this->showModal = false;
        session()->flash('success', 'Ваш отзыв успешно отправлен на модерацию!');
    }

    public function render()
    {
        return view('livewire.review-modal');
    }
}
