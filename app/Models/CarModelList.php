<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CarModelList extends Model
{
    use HasFactory, HasSlug;

    public $timestamps = false;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function make(): BelongsTo
    {
        return $this->belongsTo(CarMakeList::class, 'car_make_list_id');
    }

    public function features(): HasOne
    {
        return $this->hasOne(CarFeatureList::class, 'car_model_list_id');
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'car_model_list_id');
    }
}
