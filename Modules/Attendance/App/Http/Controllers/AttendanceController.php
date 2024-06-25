<?php

namespace Modules\Attendance\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Attendance\App\Http\Requests\CheckInRequest;
use Modules\Attendance\Repositories\AttendanceRepository;

class AttendanceController extends Controller
{

    protected $repository;

    public function __construct(AttendanceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function checkin(CheckInRequest $request)
    {
        return $this->repository->checkIn($request);
    }

    public function checkout(Request $request)
    {
        return $this->repository->checkOut($request);
    }

    public function attendanceHistory(Request $request)
    {
        $employeeId = auth()->user()->id;
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return $this->repository->getAttendanceHistory($employeeId, $startDate, $endDate);
    }
}
