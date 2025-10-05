<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryOfEquipment extends Model
{
    protected $table = 'categories_of_equipment';
    public $timestamps = false;
    protected $fillable = ['name'];
    public function category(){
        return $this->hasMany(EquipmentCategory::class, 'category_id');
    }
}
