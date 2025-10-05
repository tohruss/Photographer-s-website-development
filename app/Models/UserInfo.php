<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_info';
    public $timestamps = false;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'tel',
        'avatar'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
