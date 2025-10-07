<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
    public function categories(){
        return $this->belongsToMany(CategoryOfEquipment::class, 'equipment_category', 'equipment_id', 'category_id');
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

    public static function createWithCategories(array $data, array $categoryIds)
    {
        $equipment = self::create($data);
        $equipment->categories()->attach($categoryIds);
        return $equipment;
    }


}
