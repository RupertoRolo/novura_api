<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_id', 'name', 'icon', 'color'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
