<?php

namespace App\Domains\BillTypes\Http;

use App\Domains\BillTypes\Http\Requests\StoreBillType;
use App\Domains\BillTypes\Http\Requests\UpdateBillType;
use App\Domains\BillTypes\Http\Requests\DeleteBillType;
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
        $users = $this->repository->all();

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
    public function edit($bill_type_id)
    {
        $bill_type = $this->repository->find($bill_type_id, ['name', 'default_price']);
        return response()->json($bill_type, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBillType $request, $bill_type_id)
    {
        $this->repository->update($request->input(), $bill_type_id);

        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteBillType $request, BillType $bill_type)
    {
        $this->repository->delete($bill_type->id);

        return response()->json(null, 200);
    }

    /**
     * Remove many resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(DeleteBillType $request)
    {
        $this->repository->deleteMany($request->input());

        return response()->json(null, 200);
    }
}
