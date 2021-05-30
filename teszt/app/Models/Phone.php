<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = [
        'phoneNumber',
        'isDefault'
    ];
    protected $guarded = [
        'id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $touches = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
