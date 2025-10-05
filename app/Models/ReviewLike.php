<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewLike extends Model
{
    protected $table = 'review_like';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'review_id',
        'like'
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function review(){
        return $this->belongsTo(Review::class, 'review_id');
    }
}
