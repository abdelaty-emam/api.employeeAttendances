<?php

namespace Modules\Leaves\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Leaves\Database\factories\LeaveTypeFactory;

class LeaveType extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     */
    // protected $fillable = [];

    protected static function newFactory(): LeaveTypeFactory
    {
        //return LeaveTypeFactory::new();
    }
}
