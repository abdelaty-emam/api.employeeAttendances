<?php

namespace Modules\Leaves\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Leaves\Repositories\leaveRequestRepository;
use Modules\Leaves\App\Http\Requests\leavesRequests\StoreRequest;

class EmployeeLeaveRequestsController extends Controller
{
    protected $repository;

    public function __construct(leaveRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $response = $this->repository->createOrUpdate($request->validated());
            if ($response === true) {
                $data = ['message' => trans('leaves.applied')];
                return response()->json(['data' => $data], 201);
            } else {
                $data = ['message' => trans('leaves.unableToCreate') . $response];
                return response()->json(['data' => $data], 500);
            }
        } catch (\Exception $e) {
            $data = ['message' => trans('leaves.somethingWentWrong') . $e->getMessage()];
            return response()->json(['data' => $data], 500);
        }
    }

    public function myLeaves()
    {
        $id = auth()->user()->id;
        $data = $this->repository->findByEmployee($id);
        return response()->json(['data' => $data], 200);
    }
}
