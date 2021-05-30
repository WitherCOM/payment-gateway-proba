<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'dateOfBirth',
        'isActive'
    ];
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function phones()
    {
        return $this->hasMany(Phone::class)->where('isDefault',0);
    }
    public function defaultPhone()
    {
        return $this->hasOne(Phone::class)->where('isDefault',1);
    }
}
