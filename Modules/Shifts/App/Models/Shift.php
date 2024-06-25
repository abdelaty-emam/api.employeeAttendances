<?php

namespace Modules\Shifts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shifts\Database\factories\ShiftFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
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

    protected static function newFactory(): ShiftFactory
    {
        //return ShiftFactory::new();
    }
}
