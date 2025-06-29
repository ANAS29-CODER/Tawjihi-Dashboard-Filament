<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pray extends Model
{
    use HasFactory;

    protected $fillable = [
        'pray_text',
        'pray_image'
    ];



    protected static function booted()
    {

        static::created(function ($pray) {

            if ($pray->pray_image && \Storage::disk('public')->exists($pray->pray_image)) {

                $originalPath = $pray->pray_image;
                $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
                $originalName = pathinfo($originalPath, PATHINFO_FILENAME);

                $praySlug = \Str::slug($pray->name);
                $newFilename = "{$praySlug}-{$originalName}.{$extension}";
                $newPath = 'prays/' . $newFilename;

                \Storage::disk('public')->move($originalPath, $newPath);

                $pray->update([
                    'pray_image' => $newPath,
                ]);
            }
        });


        static::deleting(function ($pray) {
            if ($pray->pray_image && Storage::disk('public')->exists($pray->pray_image)) {
                try {
                    Storage::disk('public')->delete($pray->pray_image);
                } catch (\Exception $e) {
                    \Log::error('فشل في حذف ملف الدعاء: ' . $e->getMessage());
                }
            }
        });
    }
}
