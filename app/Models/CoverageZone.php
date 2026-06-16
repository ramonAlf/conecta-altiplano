<?php

namespace App\Models;

use App\CoverageType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CoverageZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'coverage_type',
        'node',
        'is_active',
        'center_lat',
        'center_lng',
        'radius_meters',
    ];

    protected function casts(): array
    {
        return [
            'coverage_type' => CoverageType::class,
            'is_active' => 'boolean',
        ];
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class);
    }

    public function technicians(): BelongsToMany
    {
        return $this->belongsToMany(User::class); // pivote: coverage_zone_user
    }
}
