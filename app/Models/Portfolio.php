<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $table = 'portfolio';
    public $timestamps = false;
    protected $fillable = ['user_id','photo'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
