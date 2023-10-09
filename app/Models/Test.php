<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    public function emails()
    {
        return $this->hasMany(Email::class);
    }



    protected $fillable = [
        'title',
        'created_by',
        'active'
    ];
}
