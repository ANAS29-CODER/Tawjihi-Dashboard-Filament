<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Interview extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'image',
        'link'
    ];





       protected static function booted()
    {

        static::created(function ($interview) {

            if ($interview->image && \Storage::disk('public')->exists($interview->image)) {

                $originalPath = $interview->image;
                $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                $originalName = pathinfo($originalPath, PATHINFO_FILENAME);

                $interviewSlug = \Str::slug($interview->name);
                $newFilename = "{$interviewSlug}-{$originalName}.{$extension}";
                $newPath = 'interviews/' . $newFilename;

                \Storage::disk('public')->move($originalPath, $newPath);

                $interview->update([
                    'image' => $newPath,
                ]);
            }
        });


        static::deleting(function ($interview) {
            if ($interview->image && Storage::disk('public')->exists($interview->image)) {
                try {
                    Storage::disk('public')->delete($interview->image);
                } catch (\Exception $e) {
                    \Log::error('فشل في حذف ملف المقابلة: ' . $e->getMessage());
                }
            }
        });
    }
}
