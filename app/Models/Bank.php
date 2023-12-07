<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bank
 *
 * @property int $id
 * @property string $name
 * @property string|null $logo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $logo_url
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bank extends Model
{
    const LOGO_STORAGE_PATH = 'public/images/bank/logos';

    const LOGO_PATH = 'images/bank/logos';

    protected $guarded = [];

    public function getLogoUrlAttribute(): string
    {
        return "/" . Bank::LOGO_PATH . "/" . $this->logo;
    }
}
