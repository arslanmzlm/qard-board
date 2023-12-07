<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\BankAccount
 *
 * @property int $id
 * @property int $company_id
 * @property int $bank_id
 * @property string $iban
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bank $bank
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BankAccount extends Model
{
    protected $guarded = [];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
