<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject_id',
        'book_file',
        'book_link',
        'image'
    ];



    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }


    protected static function booted()
    {

        static::created(function ($book) {
            if ($book->book_file && \Storage::disk('public')->exists($book->book_file)) {
                $originalPath = $book->book_file;
                $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                $originalName = pathinfo($originalPath, PATHINFO_FILENAME);

                $bookSlug = \Str::slug($book->name);
                $newFilename = "{$bookSlug}-{$originalName}.{$extension}";
                $newPath = 'books/' . $newFilename;

                // Rename file
                \Storage::disk('public')->move($originalPath, $newPath);

                // Update DB column
                $book->update([
                    'book_file' => $newPath,
                ]);
            }
        });
        static::deleting(function ($book) {
            if ($book->book_file && Storage::disk('public')->exists($book->book_file)) {
                Storage::disk('public')->delete($book->book_file);
            }

            if ($book->image && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }
        });

        static::updating(function ($book) {
            // Check if file has changed
            if ($book->isDirty('book_file')) {
                $original = $book->getOriginal('book_file');
                if ($original && Storage::disk('public')->exists($original)) {
                    Storage::disk('public')->delete($original);
                }
            }

            // Check if image has changed
            if ($book->isDirty('image')) {
                $original = $book->getOriginal('image');
                if ($original && Storage::disk('public')->exists($original)) {
                    Storage::disk('public')->delete($original);
                }
            }
        });
    }
}
