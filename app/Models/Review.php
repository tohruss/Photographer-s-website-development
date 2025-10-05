<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    public $timestamps = false;
    protected $fillable = [
        'author_name',
        'link_to_media',
        'comment',
        'is_approved'
    ];
    public function reviewLike(){
        return $this->hasMany(ReviewLike::class, 'review_id');
    }
}
