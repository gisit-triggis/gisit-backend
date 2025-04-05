<?php

namespace App\Models;

use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasUlids;
    use HasFactory;

    protected $table = 'marks';

    protected function casts(): array
    {
        return [
            'geometry' => Point::class,
        ];
    }

    protected $guarded = [
        'id'
    ];


}
