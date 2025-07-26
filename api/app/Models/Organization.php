<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/*
 * @property int $id
 * @property mixed $name
 * @property mixed $phone
 * @property mixed $building
 * @property mixed $activity
 */
class Organization extends Model
{
    use HasFactory, HasSlug, HasUuids;

    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(
            related: Building::class,
        );
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(
            related: Activity::class,
        );
    }
}
