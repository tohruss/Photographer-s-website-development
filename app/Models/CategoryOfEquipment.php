<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryOfEquipment extends Model
{
    protected $table = 'categories_of_equipment';
    public $timestamps = false;
    protected $fillable = ['name'];
    public function categories(){
        return $this->hasMany(EquipmentCategory::class, 'category_id');
    }
    public function equipments(){
        return $this->belongsToMany(Equipment::class, 'equipment_category', 'category_id', 'equipment_id');
    }

    public function safeDelete()
    {
        $this->equipments()->detach();
        $this->delete();
    }
}
