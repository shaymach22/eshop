<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'description',
        'price', 'stock', 'image', 'is_active'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($p) {
            $p->slug = Str::slug($p->title);
        });
    }

    public function category()   { return $this->belongsTo(Category::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
    public function reviews()    { return $this->hasMany(Review::class); }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}