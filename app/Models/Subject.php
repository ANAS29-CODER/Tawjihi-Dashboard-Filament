<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'branch_id',
        'description',
        'image',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
