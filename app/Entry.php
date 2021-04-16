<?php

namespace App;

use App\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @method static create(array $data)
 */
class Entry extends Model
{
    protected $guarded = [];

    protected  $with = ['category'];

    protected $appends = ['formattedDate', 'shortDescription'];

    public function scopeForThisWeek($query)
    {
        $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeForWeekEnding($query, $date)
    {
        $date = Carbon::parse($date);

        $query->whereBetween('created_at', [
            $date->copy()->startOfWeek(),
            $date->copy()->endOfWeek()
        ]);
    }

    public function scopeForDay($query, $date)
    {
        $date = Carbon::parse($date);

        $query->whereBetween('created_at', [
            $date->copy()->startOfDay(),
            $date->copy()->endOfDay()
        ]);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getShortDescriptionAttribute() : string
    {
        return strlen($this->description) > 20  ? substr($this->description, 0, 17) . '...' : $this->description;
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('F jS Y g:iA');
    }

}
