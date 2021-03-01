<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use UsesUuid;

    protected $table = 'locations';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['street', 'number', 'city', 'state', 'postcode', 'latitude', 'longitude', 'timezone_offset',
        'timezone_description', 'person_uuid'];
    protected $hidden = ['created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}
