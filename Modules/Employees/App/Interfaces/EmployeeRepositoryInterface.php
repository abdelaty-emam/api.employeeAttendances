<?php

namespace Modules\Employees\App\Interfaces;



interface EmployeeRepositoryInterface
{
    public function createOrUpdate(array $request, $id);

}
