<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function organization(): HasMany
    {
        return $this->hasMany(
            related: Organization::class,
        );
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            related: self::class,
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            related: self::class,
        );
    }
}
