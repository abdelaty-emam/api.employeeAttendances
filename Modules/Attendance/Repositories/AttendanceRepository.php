<?php

namespace Modules\Attendance\Repositories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Modules\Common\App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Modules\Attendance\App\Models\Attendance;
use Modules\Attendance\App\Interfaces\AttendanceRepositoryInterface;
use Modules\Attendance\App\Http\Resources\AttendanceResource;

class AttendanceRepository implements AttendanceRepositoryInterface
{

    protected $model;

    public function __construct(Attendance $model)
    {
        $this->model = $model;
    }
    public function checkIn($request)
    {
        $row = new $this->model;
        $row->date = now()->toDateString();
        $row->time_in = now()->toTimeString();
        $row->employee_id = auth()->user()->id;
        $row->latitude_in = $request->latitude;
        $row->longitude_in = $request->longitude;
        $row->save();
        if ($request->has('image_base64')) {
            $this->savePhoto($row, $request->photo_base64, 'checkin');
        }
    }

    public function checkOut($request)
    {
        $userId = Auth::id();
        $date = now()->toDateString();

        $row = $this->model
            ->where('employee_id', $userId)
            ->whereDate('date', $date)
            ->first();

        if (!$row) {
            return response()->json(['error' => 'No check-in'], 400);
        }

        if ($row->status ===  $this->model::STATUS_CHECKED_OUT) {
            return response()->json(['error' => 'employee has already checked out today.'], 400);
        }

        $row->time_out = now()->toTimeString();
        $row->latitude_out = $request->latitude;
        $row->longitude_out = $request->longitude;
        $row->status = $this->model::STATUS_CHECKED_OUT;
        $row->save();

        if ($request->has('image_base64')) {
            $this->savePhoto($row, $request->photo_base64, 'checkout');
        }

        return response()->json($row);
    }


    public function getAttendanceHistory($employeeId, $startDate, $endDate)
    {
        $rows = $this->model
            ->where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();

        return [
            'rows' => AttendanceResource::collection($rows),
        ];
    }

    public function savePhoto($attendance, $photoBase64, $type)
    {
        $photoData = base64_decode($photoBase64);
        $photoPath = 'photos/' . Str::random(20) . '.png';
        Storage::disk('public')->put($photoPath, $photoData);

        $photo = new Image();
        $photo->path = $photoPath;
        $photo->type = $type;
        $photo->save();

        $attendance->photos()->save($photo);
    }
}
