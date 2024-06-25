<?php

namespace Modules\Attendance\App\Interfaces;



interface AttendanceRepositoryInterface
{
    public function checkIn(array $request);
    public function checkOut(array $request);
}
