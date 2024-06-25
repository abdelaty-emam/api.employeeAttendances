<?php

namespace Modules\Leaves\App\Interfaces;



interface LeaveRequestsRepositoryInterface
{
    public function index($request);
    public function createOrUpdate(array $request, $id);
    public function find($id);
    public function destroy($id);
    public function findByEmployee($id);

}
