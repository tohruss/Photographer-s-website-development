<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'title',
        'photo',
        'description'
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category(){
        return $this->hasMany(EquipmentCategory::class, 'equipment_id');
    }

}
