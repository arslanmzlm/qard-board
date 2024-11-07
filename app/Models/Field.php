<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Field
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string|null $logo
 * @property array|null $values
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $logo_url
 * @method static \Illuminate\Database\Eloquent\Builder|Field newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Field newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Field query()
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereValues($value)
 * @mixin \Eloquent
 */
class Field extends Model
{
    const TYPE_BASIC = 'basic';

    const TYPE_BANK = 'bank';

    const TYPE_CARD = 'card';

    const TYPES = [
        self::TYPE_BASIC,
        self::TYPE_BANK,
        self::TYPE_CARD,
    ];

    const LOGO_PATH = 'images/fields/logos';

    protected $guarded = [];

    protected $appends = ['logo_url'];

    protected $casts = [
        'values' => 'json',
    ];

    public function getLogoUrlAttribute(): string
    {
        return "/" . self::LOGO_PATH . "/" . $this->logo;
    }
}
