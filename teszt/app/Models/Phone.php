<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

    protected $touches = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
