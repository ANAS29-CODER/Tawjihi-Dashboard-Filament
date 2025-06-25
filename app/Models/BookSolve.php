<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookSolve extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'name',
        'book_link',
        'book_file',
    ];


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }



     protected static function booted()
    {

        static::created(function ($bookSolve) {
            if ($bookSolve->book_file && \Storage::disk('public')->exists($bookSolve->book_file)) {
                $originalPath = $bookSolve->book_file;
                $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                $originalName = pathinfo($originalPath, PATHINFO_FILENAME);

                $bookSlug = \Str::slug($bookSolve->name);
                $newFilename = "{$bookSlug}-{$originalName}.{$extension}";
                $newPath = 'books-solve/' . $newFilename;

                \Storage::disk('public')->move($originalPath, $newPath);

                $bookSolve->update([
                    'book_file' => $newPath,
                ]);
            }



        });
        static::deleting(function ($bookSolve) {
            if ($bookSolve->book_file && Storage::disk('public')->exists($bookSolve->book_file)) {
                Storage::disk('public')->delete($bookSolve->book_file);
            }

            if ($bookSolve->image && Storage::disk('public')->exists($bookSolve->image)) {
                Storage::disk('public')->delete($bookSolve->image);
            }
        });

        static::updating(function ($bookSolve) {
            // Check if file has changed
            if ($bookSolve->isDirty('book_file')) {
                $original = $bookSolve->getOriginal('book_file');
                if ($original && Storage::disk('public')->exists($original)) {
                    Storage::disk('public')->delete($original);
                }
            }


            if ($bookSolve->isDirty('image')) {
                $original = $bookSolve->getOriginal('image');
                if ($original && Storage::disk('public')->exists($original)) {
                    Storage::disk('public')->delete($original);
                }
            }
        });
    }
}
