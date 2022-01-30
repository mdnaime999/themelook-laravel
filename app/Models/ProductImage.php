<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $appends = ['path_image'];

    public function getPathImageAttribute()
    {
        if (!is_null($this->name)) {
            return asset('images/' . $this->name);
        } else {
            return null;
        }
    }
}
