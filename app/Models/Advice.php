<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advice extends Model
{
    use HasFactory;

    protected $fillable=[

        'title',
        'advice_text',
        'subject_id'
    ];


    public function subject()
    {
       return $this->belongsTo(Subject::class);
    }
}
