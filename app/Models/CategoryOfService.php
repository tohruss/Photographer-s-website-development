<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryOfService extends Model
{
    protected $table = 'categories_of_services';
    public $timestamps = false;
    protected $fillable = ['name'];
    public function serviceCategories(){
        return $this->belongsToMany(ServiceCategory::class, 'category_id');
    }
}
