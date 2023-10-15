<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;


    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_id');
    }

    protected $fillable = [
        'email_id',
        'answer',
        'dep_id',
    ];


}
