<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use UsesUuid;

    protected $table = 'pictures';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['large', 'medium', 'thumbnail', 'person_uuid'];
    protected $hidden = ['created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}
