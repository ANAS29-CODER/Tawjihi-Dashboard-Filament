<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'selected_sections',
        'subject_id',
        'section_id',
    ];


    protected $casts = [
        'selected_sections' => 'array',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

 
}
