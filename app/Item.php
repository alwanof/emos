<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    protected $fillable = [
        'title', 'slug','description','price','category_id','user_id','youtube'
    ];
    protected $casts = [
        'available' => 'boolean',
    ];

    protected $appends = ['avatar'];

    public function getAvatarAttribute()
    {
        $path = Storage::exists('/public/items/' . $this->id . '.jpg');
        $avatar = ($path) ? asset('storage/items/' . $this->id . '.jpg') : asset('storage/items/0.jpg');
        return $avatar;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
