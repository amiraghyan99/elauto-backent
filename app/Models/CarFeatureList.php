<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarFeatureList extends Model
{
    public $timestamps = false;

    use HasFactory;

    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModelList::class, 'car_model_list_id', 'id');
    }
}
