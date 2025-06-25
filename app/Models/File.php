<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'file_link',
        'file',
        'image',
        'subject_id',
        'section_id',
    ];



    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }


      protected static function booted()
    {

        static::created(function ($file) {

            if ($file->file && \Storage::disk('public')->exists($file->file)) {
                
                $originalPath = $file->file;
                $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                $originalName = pathinfo($originalPath, PATHINFO_FILENAME);

                $fileSlug = \Str::slug($file->name);
                $newFilename = "{$fileSlug}-{$originalName}.{$extension}";
                $newPath = 'files/' . $newFilename;

                \Storage::disk('public')->move($originalPath, $newPath);

                $file->update([
                    'file' => $newPath,
                ]);
            }
            // the same thing for image
            if ($file->image && \Storage::disk('public')->exists($file->image)) {

                $originalPath = $file->image;
                $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                $originalName = pathinfo($originalPath, PATHINFO_FILENAME);

                $fileSlug = \Str::slug($file->name);
                $newFilename = "{$fileSlug}-{$originalName}.{$extension}";
                $newPath = 'files/images/' . $newFilename;

                \Storage::disk('public')->move($originalPath, $newPath);

                $file->update([
                    'image' => $newPath,
                ]);
            }


        });
        static::deleting(function ($file) {
            if ($file->file && Storage::disk('public')->exists($file->file)) {
                Storage::disk('public')->delete($file->file);
            }

            if ($file->image && Storage::disk('public')->exists($file->image)) {
                Storage::disk('public')->delete($file->image);
            }
        });

        static::updating(function ($file) {
            // Check if file has changed
            if ($file->isDirty('file')) {
                $original = $file->getOriginal('file');
                if ($original && Storage::disk('public')->exists($original)) {
                    Storage::disk('public')->delete($original);
                }
            }


            if ($file->isDirty('image')) {
                $original = $file->getOriginal('image');
                if ($original && Storage::disk('public')->exists($original)) {
                    Storage::disk('public')->delete($original);
                }
            }
        });
    }
}
