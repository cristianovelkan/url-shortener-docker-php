<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id',
    ];

    public function urls()
    {
        return $this->hasMany(Url::class, 'user_id');
    }
}
