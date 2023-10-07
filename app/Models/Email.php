<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
    
    protected $fillable = [
        'title',
        'subject',
        'body',
        'test_id',
        'sender_address',
        'cc_addresses_list',
        'created_by',
        'active',
        'is_correct'
    ];
    
    protected $casts = [
        'sender_address' => 'array',
        'cc_addresses_list' => 'array',
    ];

}
