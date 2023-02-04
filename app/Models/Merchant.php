<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Merchant extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $guarded=[];
    protected $appends = ['main_image'];

    protected function getMainImageAttribute()
    {
        return $this->getMedia('main_image')[0]->getFullUrl();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')->width(368)->height(232)->sharpen(10);
    }
}
