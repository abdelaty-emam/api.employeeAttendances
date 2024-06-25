<?php

namespace Modules\Shifts\App\Interfaces;



interface ShiftRepositoryInterface
{
    public function index($request);
    public function createOrUpdate(array $request, $id);
    public function find($id);
    public function destroy($id);
}
