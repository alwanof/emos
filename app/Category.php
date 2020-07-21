<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'user_id', 'fav'
    ];
    protected $casts = [
        'fav' => 'boolean',
    ];

    protected $appends = ['itemsSize'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getItemsSizeAttribute()
    {
        return Item::where('category_id', $this->id)->get()->count();
    }
}