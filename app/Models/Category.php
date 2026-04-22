<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($c) {
            $c->slug = Str::slug($c->name);
        });
    }

    public function products() { return $this->hasMany(Product::class); }
}