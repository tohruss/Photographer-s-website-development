<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    public $timestamps = false;
    protected $fillable = [
        'link_to_media',
        'comment',
        'is_approved',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewLike(){
        return $this->hasMany(ReviewLike::class, 'review_id');
    }
}
