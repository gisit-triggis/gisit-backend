<?php

namespace App\Models;

use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class City extends Model
{
    use HasFactory;
    use HasUlids;

    protected $table = 'cities';

    protected $guarded = [
        'id'
    ];

    protected function casts(): array
    {
        return [
            'geometry' => Point::class,
        ];
    }

    protected $appends = [
        'type',
    ];

    public function getTypeAttribute()
    {
        return 'Feature';
    }
}
