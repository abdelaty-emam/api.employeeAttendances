<?php

namespace Modules\Leaves\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Modules\Leaves\Repositories\leaveRequestRepository;
use Modules\Leaves\App\Http\Requests\leavesRequests\UpdateRequest;

class LeaveRequestsController extends Controller
{
    protected $repository;

    public function __construct(leaveRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->repository->index($request->input());
        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data = $this->repository->find($id);
        return response()->json(['data' => $data], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(UpdateRequest $request, $id)
    {
        $leaveRequest = $this->repository->find($id)['row'];
        $leaveRequest->update([
            'status' => $request->status,
            'approved_by' => Auth::id()
        ]);

        return response()->json(['message' => __('leaves.status')], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $response = $this->repository->destroy($id);
            if ($response === true) {
                $data = ['message' => trans('leaves.deleted')];
                return response()->json(['data' => $data], 200);
            } else {
                $data = ['message' => trans('leaves.unableToDelete') . $response];
                return response()->json(['data' => $data], 500);
            }
        } catch (\Exception $e) {
            $data = ['message' => trans('leaves.somethingWentWrong') . $e->getMessage()];
            return response()->json(['data' => $data], 500);
        }
    }
}
