<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Tests\Integration\Database\EloquentHasManyThroughTest\Category;

class EquipmentCategory extends Model
{
    protected $table = 'equipment_category';
    public $timestamps = false;
    protected $fillable = ['equipment_id', 'category_id'];
    public function equipment(){
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function category(){
        return $this->belongsTo(CategoryOfEquipment::class, 'category_id');
    }
}
