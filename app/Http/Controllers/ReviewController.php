<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{

    public function approve(string $id, bool $approve = true)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = $approve;
        $review->save();

        return Redirect::back()->with('success', $approve ? 'Отзыв одобрен' : 'Отзыв скрыт');
    }

    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);

        $review->reviewLike()->delete();
        $review->delete();

        return Redirect::back()->with('success', 'Отзыв удалён');
    }
}
