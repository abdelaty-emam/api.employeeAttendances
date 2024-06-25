<?php

namespace Modules\Shifts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Shifts\App\Http\Requests\StoreRequest;
use Modules\Shifts\Repositories\ShiftRepository;
use Modules\Shifts\App\Http\Requests\UpdateRequest;

class ShiftsController extends Controller
{

    protected $repository;

    public function __construct(ShiftRepository $repository)
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shifts::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $response = $this->repository->createOrUpdate($request->validated());
            if ($response === true) {
                $data = ['message' => trans('shift.created')];
                return response()->json(['data' => $data], 201);
            } else {
                $data = ['message' => trans('shift.unableToCreate') . $response];
                return response()->json(['data' => $data], 500);
            }
        } catch (\Exception $e) {
            $data = ['message' => trans('shift.somethingWentWrong') . $e->getMessage()];
            return response()->json(['data' => $data], 500);
        }
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
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('shifts::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id): JsonResponse
    {
        try {
            $response = $this->repository->createOrUpdate($request->validated(), $id);
            if ($response === true) {
                $data = ['message' => trans('shift.updated')];
                return response()->json(['data' => $data], 200);
            } else {
                $data = ['message' => trans('shift.unableToUpdate') . $response];
                return response()->json(['data' => $data], 500);
            }
        } catch (\Exception $e) {
            $data = ['message' => trans('shift.somethingWentWrong') . $e->getMessage()];
            return response()->json(['data' => $data], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $response = $this->repository->destroy($id);
            if ($response === true) {
                $data = ['message' => trans('shifts.deleted')];
                return response()->json(['data' => $data], 200);
            } else {
                $data = ['message' => trans('shifts.unableToDelete') . $response];
                return response()->json(['data' => $data], 500);
            }
        } catch (\Exception $e) {
            $data = ['message' => trans('shifts.somethingWentWrong') . $e->getMessage()];
            return response()->json(['data' => $data], 500);
        }
    }
}
