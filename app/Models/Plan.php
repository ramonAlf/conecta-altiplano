<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'speed',
        'is_active',
        'type',
        'special_price',
        'special_price_start_date',
        'special_price_end_date',
    ];

    protected $casts = [
        'special_price_start_date' => 'date',
        'special_price_end_date' => 'date',
    ];

    const TYPE_RESIDENTIAL = 'residential';

    const TYPE_BUSINESS = 'business';

    const TYPE_ENTERPRISE = 'enterprise';

    protected $enum = [
        'type' => self::TYPE_RESIDENTIAL | self::TYPE_BUSINESS | self::TYPE_ENTERPRISE,
    ];
}
