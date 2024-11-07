<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CompanyField
 *
 * @property int $id
 * @property int $company_id
 * @property int $field_id
 * @property int $order
 * @property array|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Field $field
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyField query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyField whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyField whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyField whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyField whereValue($value)
 * @mixin \Eloquent
 */
class CompanyField extends Model
{
    protected $guarded = [];

    protected $casts = [
        'value' => 'json',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }
}
