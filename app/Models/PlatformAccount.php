<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PlatformAccount
 *
 * @property int $id
 * @property int $company_id
 * @property int $platform_id
 * @property string $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Platform $platform
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformAccount whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformAccount whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformAccount wherePlatformId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PlatformAccount extends Model
{
    protected $guarded = [];

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
