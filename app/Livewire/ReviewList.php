<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;

class ReviewList extends Component
{
    public $reviews = [];

    public function mount()
    {
        $this->loadReviews();
    }

    public function loadReviews()
    {
        $this->reviews = Review::where('is_approved', true)
            ->withCount(['reviewLike as likes_count' => fn ($q) => $q->where('like', 1)])
            ->get();
    }

    public function render()
    {
        return view('livewire.review-list');
    }
}
