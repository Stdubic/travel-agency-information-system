<?php

namespace Modules\Base\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Accommodation\Entities\AccommodationObject;
use Modules\Accommodation\Entities\AccommodationUnit;
use Modules\Accommodation\Entities\Country;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'oib',
        'address',
        'city',
        'postal_code',
        'country_id',
        'tel_num',
        'mobile_num',
        'fax',
        'skype',
        'bank_name',
        'iban',
        'swift',
        'affiliate_num',
        'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Morph to natural and legal user
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function userable()
    {
        return $this->morphTo();
    }

    /**
     * Hash pass
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * User belongs to country
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * User has many accommodation unites
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function units()
    {
        return $this->hasManyThrough(
            AccommodationUnit::class,
            AccommodationObject::class,
            'supplier_id',
            'accommodation_object_id',
            'id',
            'id'
        );
    }

    /**
     * Name accessor
     *
     * @param $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        if($value === null) {
            return $this->userable->first_name . ' ' . $this->userable->last_name;
        } else {
            return $value;
        }
    }

    /**
     * Name accessor
     *
     * @param $value
     * @return string
     */
    public function getTypeAttribute($value)
    {
        if($this->userable_type === null) {
            return '';
        }

        if($this->userable_type === 'Modules\Base\Entities\LegalUser') {
            return 'legal';
        } else {
            return 'private';
        }
    }

    /**
     * Check if role exists
     *
     * @return bool
     */
    public function roleExists()
    {
        if(!$this->roles()->count()) {
            return false;
        }

        return true;
    }
}
