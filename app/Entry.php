<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 */
class Entry extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
