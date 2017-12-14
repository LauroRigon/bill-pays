<?php

namespace App\Domains\BillTypes\Http;

use App\Http\Requests\BillType\StoreBillType;
use App\Http\Requests\BillType\UpdateBillType;
use App\Http\Requests\BillType\DeleteBillType;
use App\Domains\BillTypes\BillType;
use App\Domains\BillTypes\Repositories\BillTypeRepository;

use App\Http\Controllers\Controller;

class BillTypeController extends Controller
{
    public function __construct(BillTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->repository->paginate(10);

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBillType $request)
    {
        $this->repository->create($request->input());

        return response()->json(null, 200);
    }

    /**
     * Return user data to edit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BillType $user)
    {
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBillType $request, BillType $user)
    {
        $this->repository->update($request->input(), $user->id);

        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteBillType $request, BillType $user)
    {
        $this->repository->delete($user->id);

        return response()->json(null, 200);
    }
}
