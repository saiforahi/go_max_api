<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PaymentService extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $guarded=[];
    protected $appends = ['photo'];

    protected function getPhotoAttribute()
    {
        return $this->getMedia('photo')[0]->getFullUrl();
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')->width(368)->height(232)->sharpen(10);
    }
}
