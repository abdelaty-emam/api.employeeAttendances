<?php

namespace Modules\Leaves\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Leaves\App\Models\LeaveType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Leaves\Database\factories\LeaveRequestFactory;

class LeaveRequest extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     */
    // protected $fillable = [];
    protected $casts = [
        'status' => 'string',
    ];

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    protected static function newFactory(): LeaveRequestFactory
    {
        //return LeaveRequestFactory::new();
    }
}
