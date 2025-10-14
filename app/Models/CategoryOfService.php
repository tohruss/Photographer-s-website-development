<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryOfService extends Model
{
    protected $table = 'categories_of_services';
    public $timestamps = false;
    protected $fillable = ['name'];
    public function services(){
        return $this->belongsToMany(Service::class, 'service_category', 'category_id', 'service_id');
    }

    public function safeDelete()
    {
        $services = $this->services;
        $this->services()->detach();
        $this->delete();

        foreach ($services as $service) {
            if ($service->categories()->count() === 0) {
                $service->update(['is_available' => false]);
            }
        }
    }
}
