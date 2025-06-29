<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable=[
        'email',
        'whatsapp_link',
        'facbook_link',
        'instagram_link',
        'telegarm_link'
    ];
}
