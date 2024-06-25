<?php

namespace Modules\WorkLocations\App\Interfaces;



interface WorkLocationRepositoryIntrface
{
    public function index($request);
    public function createOrUpdate(array $request, $id);
    public function find($id);
    public function destroy($id);
}
