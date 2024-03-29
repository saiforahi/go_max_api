<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BkashMerchant extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function extendable()
    {
        return $this->morphTo();
    }
}
