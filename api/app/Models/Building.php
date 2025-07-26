<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/*
 * @property int $id
 * @property string $address
 * @property float $latitude
 * @property float $longitude
 */
class Building extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function organization(): HasMany
    {
        return $this->hasMany(
            related: Organization::class,
        );
    }
}
