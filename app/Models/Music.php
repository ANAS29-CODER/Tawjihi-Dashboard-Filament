<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Music extends Model
{
    use HasFactory;

    protected $table = "musics";

    protected $fillable = [

        'name',
        'music_link',
        'music_file',
    ];






    protected static function booted()
    {

        static::created(function ($music) {

            if ($music->music_file && \Storage::disk('public')->exists($music->music_file)) {

                $originalPath = $music->music_file;
                $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                $originalName = pathinfo($originalPath, PATHINFO_FILENAME);

                $musicSlug = \Str::slug($music->name);
                $newFilename = "{$musicSlug}-{$originalName}.{$extension}";
                $newPath = 'musics/' . $newFilename;

                \Storage::disk('public')->move($originalPath, $newPath);

                $music->update([
                    'music_file' => $newPath,
                ]);
            }
        });


        static::deleting(function ($music) {
            if ($music->music_file && Storage::disk('public')->exists($music->music_file)) {
                try {
                    Storage::disk('public')->delete($music->music_file);
                } catch (\Exception $e) {
                    \Log::error('فشل في حذف ملف الموسيقى: ' . $e->getMessage());
                }
            }
        });
    }
}
