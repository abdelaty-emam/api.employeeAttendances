<?php

namespace Modules\WorkLocations\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\WorkLocations\Database\factories\WorkLocationFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkLocation extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];


    /**
     * The attributes that are mass assignable.
     */
    // protected $fillable = [];


    public function employees()
    {
        return $this->hasMany(User::class);
    }

    protected static function newFactory(): WorkLocationFactory
    {
        //return WorkLocationFactory::new();
    }
}
