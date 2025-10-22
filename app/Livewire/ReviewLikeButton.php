<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ReviewLike;
use Illuminate\Support\Facades\Auth;

class ReviewLikeButton extends Component
{
    public $reviewId;
    public $isLiked = false;
    public $likesCount = 0;

    protected $listeners = ['refreshLikes' => '$refresh'];

    public function mount($reviewId)
    {
        $this->reviewId = $reviewId;
        $this->loadState();
    }

    public function loadState()
    {
        if (Auth::check()) {
            $this->isLiked = ReviewLike::where('user_id', Auth::id())
                ->where('review_id', $this->reviewId)
                ->where('like', 1)
                ->exists();
        }

        $this->likesCount = ReviewLike::where('review_id', $this->reviewId)
            ->where('like', 1)
            ->count();
    }

    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();

        // Проверяем, есть ли уже запись
        $like = ReviewLike::where('user_id', $userId)
            ->where('review_id', $this->reviewId)
            ->first();

        if ($like) {
            if ($like->like == 1) {
                $like->delete(); // Удаляем лайк
                $this->isLiked = false;
                $this->likesCount--;
            } else {
                $like->update(['like' => 1]); // Меняем дизлайк на лайк
                $this->isLiked = true;
                $this->likesCount++;
            }
        } else {
            // Нет записи — создаём лайк
            ReviewLike::create([
                'user_id' => $userId,
                'review_id' => $this->reviewId,
                'like' => 1,
            ]);
            $this->isLiked = true;
            $this->likesCount++;
        }

        // Явно обновляем состояние
        $this->loadState();
    }

    public function render()
    {
        return view('livewire.review-like-button');
    }
}
