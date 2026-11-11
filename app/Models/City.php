<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'category', 'short_description', 'description',
        'landmark', 'population', 'visited_on', 'image_path',
    ];

    protected $casts = [
        'population' => 'integer',
        'visited_on' => 'date',
    ];

    /**
     * Date mutator: normalizes a user-entered date to YYYY-MM-DD.
     * The field is optional because the original LR2 did not contain dates.
     */
    public function setVisitedOnAttribute($value): void
    {
        $this->attributes['visited_on'] = filled($value)
            ? Carbon::parse($value)->format('Y-m-d')
            : null;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : null;
    }
}
