<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Tests\Integration\Database\EloquentHasManyThroughTest\Category;

class ServiceCategory extends Model
{
    protected $table = 'service_category';
    public $timestamps = false;
    protected $fillable = ['service_id', 'category_id'];
    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function categoryOfService(){
            return $this->belongsTo(CategoryOfService::class, 'category_id');
    }
}
