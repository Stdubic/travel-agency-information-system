<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;

class LegalUser extends Model
{
    protected $fillable = ['legal_id'];

    /**
     * Legal user morphs to user
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
