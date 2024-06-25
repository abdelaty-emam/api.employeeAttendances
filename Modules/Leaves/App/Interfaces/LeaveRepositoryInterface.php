<?php

namespace Modules\Leaves\App\Interfaces;



interface LeaveRepositoryInterface
{
    public function index($request);
    public function createOrUpdate(array $request, $id);
    public function find($id);
    public function destroy($id);
}
