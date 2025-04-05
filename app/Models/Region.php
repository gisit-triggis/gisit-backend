<?php

namespace App\Models;

use Clickbar\Magellan\Data\Geometries\MultiPolygon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    use HasUlids;

    protected $table = 'regions';

    protected $guarded = [
        'id'
    ];

    protected function casts(): array
    {
        return [
            'geometry' => MultiPolygon::class,
        ];
    }

    protected $appends = [
        'type',
    ];

    public function getTypeAttribute()
    {
        return 'FeatureCollection';
    }
}
