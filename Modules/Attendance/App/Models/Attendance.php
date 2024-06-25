<?php

namespace Modules\Attendance\App\Models;

use App\Models\User;
use Modules\Common\App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Attendance\Database\factories\AttendanceFactory;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    const STATUS_NOT_CHECKED_IN = 'not_checked_in';
    const STATUS_CHECKED_IN = 'checked_in';
    const STATUS_CHECKED_OUT = 'checked_out';

    /**
     * The attributes that are mass assignable.
     */
    // protected $fillable = [];



    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function checkinImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'checkin');
    }

    public function checkoutImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'checkout');
    }

    protected static function newFactory(): AttendanceFactory
    {
        //return AttendanceFactory::new();
    }
}
