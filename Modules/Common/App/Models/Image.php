<?php

namespace Modules\Common\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Database\factories\ImageFactory;

class Image extends Model
{
    use HasFactory;
    protected $guarded = [];


    /**
     * The attributes that are mass assignable.
     */
    // protected $fillable = [];

    public function imageable()
    {
        return $this->morphTo();
    }

    protected static function newFactory(): ImageFactory
    {
        //return ImageFactory::new();
    }
}
