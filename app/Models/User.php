<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use UsesUuid;

    protected $table = 'users';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['uuid', 'username', 'password', 'salt', 'md5', 'sha1', 'sha256', 'person_uuid'];
    protected $hidden = ['password', 'salt', 'md5', 'sha1', 'sha256'];
    const RECORDS_PER_PAGE = 50;

    public function person() {
        return $this->hasOne(Person::class, 'user_uuid', 'uuid');
    }

    public function picture() {
        return $this->hasOne(Picture::class, 'user_uuid', 'uuid');
    }

    public function location() {
        return $this->hasOne(Location::class, 'user_uuid', 'uuid');
    }
}
