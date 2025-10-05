<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    public $timestamps = false;
    protected $fillable = [
        'title',
        'price',
        'description',
        'photo'
    ];
    public function favoriteServices(){
        return $this->belongsToMany(FavoriteService::class, 'service_id');
    }
    public function serviceCategories(){
        return $this->belongsToMany(ServiceCategory::class, 'service_id');
    }

}
