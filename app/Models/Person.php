<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Person extends Model
{
    use UsesUuid;

    protected $table = 'people';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id_name', 'id_value', 'title', 'first_name', 'email', 'last_name', 'gender', 'birthday',
        'phone', 'cell', 'nat', 'registered'];
    protected $appends = ['name'];
    protected $dates = ['birthday', 'registered'];
    protected $casts = [
        'birthday' => 'datetime:d/m/Y',
        'registered' => 'datetime:d/m/Y H:i:s'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function getGenderAttribute()
    {
        return $this->attributes['gender'] === 'male' ? 'Masculino' : 'Feminino';
    }

    public function setGenderAttribute($gender)
    {
        $this->attributes['gender'] = strtolower($gender) === 'masculino' ? 'male' : 'female';
    }

    public function setBirthdayAttribute($birthday)
    {
        $this->attributes['birthday'] = Carbon::createFromFormat('d/m/Y', $birthday)->format('Y-m-d');
    }

    public function getNameAttribute()
    {
        return "{$this->attributes['first_name']} {$this->attributes['last_name']}";
    }
}
