<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{

    public function index(): JsonResponse
    {
        $reviews = Review::where('is_approved', true)
            ->get([
                'id',
                'author_name',
                'link_to_media',
                'comment'
            ])
            ->map(function ($review) {
                // Подсчитываем количество лайков (like = 1)
                $likes = $review->reviewLike->where('like', 1)->count();

                $review->likes_count = $likes;
                unset($review->reviewLike); // убираем связь из ответа

                return $review;
            });

        return response()->json([
            'success' => true,
            'data' => $reviews,
        ]);
    }


    public function approve(string $id, bool $approve = true): JsonResponse
    {
        $review = Review::findOrFail($id);
        $review->is_approved = $approve;
        $review->save();

        return response()->json([
            'success' => true,
            'message' => $approve
                ? 'Отзыв одобрен'
                : 'Отзыв скрыт',
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $review = Review::findOrFail($id);

        $review->reviewLike()->delete();

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Отзыв удалён',
        ]);
    }
}
