<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    protected $table = 'services';
    public $timestamps = false;
    protected $fillable = [
        'title',
        'price',
        'description',
        'photo',
        'is_available',
    ];
    public function favoriteServices(){
        return $this->belongsToMany(FavoriteService::class, 'service_id');
    }
    public function categories(){
        return $this->belongsToMany(CategoryOfService::class, 'service_category', 'service_id', 'category_id');
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? Storage::url($this->photo) : null;
    }

    public function deletePhoto()
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            Storage::disk('public')->delete($this->photo);
        }
    }
    public function updatePhoto($file)
    {
        $this->deletePhoto();
        $this->photo = $file->store('equipment', 'public');
        $this->save();
    }

}
