<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property string $state
 * @property string $slug
 * @property string|null $logo
 * @property string|null $cover
 * @property string|null $qrcode
 * @property string|null $theme
 * @property string $title
 * @property string|null $subtitle
 * @property string|null $description
 * @property string|null $phone
 * @property string|null $phone_title
 * @property string|null $email
 * @property string|null $email_title
 * @property string|null $website
 * @property string|null $website_title
 * @property string|null $address
 * @property string|null $address_link
 * @property string|null $address_link_title
 * @property string|null $survey_link
 * @property string|null $survey_title
 * @property string|null $banks_title
 * @property string|null $platforms_title
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BankAccount> $bankAccounts
 * @property-read int|null $bank_accounts_count
 * @property-read string $address_text
 * @property-read string $cover_url
 * @property-read string $description_text
 * @property-read string $logo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PlatformAccount> $platformAccounts
 * @property-read int|null $platform_accounts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddressLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddressLinkTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereBanksTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmailTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePhoneTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePlatformsTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereQrcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSurveyLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereSurveyTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereWebsiteTitle($value)
 * @mixin \Eloquent
 */
class Company extends Model
{
    const THEME_GRAY = 'gray';

    const THEME_RED = 'red';

    const DEFAULT_THEME = Company::THEME_GRAY;

    const THEMES = [
        Company::THEME_GRAY,
        Company::THEME_RED,
    ];

    const STATE_CREATED = 'created';

    const STATE_ACTIVE = 'active';

    const STATE_PASSIVE = 'passive';

    const LOGO_PATH = 'images/company/logos';

    const COVER_PATH = 'images/company/covers';

    protected $guarded = [];

    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    public function platformAccounts(): HasMany
    {
        return $this->hasMany(PlatformAccount::class);
    }

    public function getLogoUrlAttribute(): string
    {
        return "/" . Company::LOGO_PATH . "/" . $this->logo;
    }

    public function getCoverUrlAttribute(): string
    {
        return "/" . Company::COVER_PATH . "/" . $this->cover;
    }

    public function getDescriptionTextAttribute(): string
    {
        return nl2br(e($this->description));
    }

    public function getAddressTextAttribute(): string
    {
        return nl2br(e($this->address));
    }
}
