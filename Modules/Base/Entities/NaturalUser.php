<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;

class NaturalUser extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'id_num',
        'birth_date',
        'passport_num',
        'passport_issued_at',
        'passport_expired_at',
        'nationality',
        'sex',
        'website'
    ];

    /**
     * Natural user morhps to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    /**
     * Deletes morphed relation
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        $result = parent::delete();
        if($result == true)
        {
            $this->user()->delete();

            return true;

        }

        return false;
    }
}
