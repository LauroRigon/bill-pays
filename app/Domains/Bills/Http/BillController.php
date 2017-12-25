<?php

namespace App\Domains\Bills\Http;

use App\Domains\Bills\Http\Requests\PayBill;
use App\Domains\Bills\Bill;
use Illuminate\Http\Request;
use App\Domains\Clients\Client;
use App\Http\Controllers\Controller;
use App\Domains\Bills\Repositories\BillRepository;
use App\Domains\Bills\Http\Requests\StoreBill;

class BillController extends Controller
{
    public function __construct(BillRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBill $request)
    {
        $this->repository->storeManyBills($request->input());

        return response()->json([
            'success' => true,
            'message' => "Contas cadastradas!",
            'data' => null
        ], 200);
    }

    /**
     * Retorna uma lista de contas vencidas
     *
     * @return \Illuminate\Http\Response
     */
    public function getExpireds()
    {
        $expireds = $this->repository->getAllExpireds();

        return response()->json($expireds, 200);
    }

    /**
     * Retorna uma lista de contas que não estão vencidas
     *
     * @return \Illuminate\Http\Response
     */
    public function getNotExpireds()
    {
        $notExpireds = $this->repository->getAllNotExpireds();

        return response()->json($notExpireds, 200);
    }

    /**
     * Retorna uma conta pelo seu id
     *
     * @return \Illuminate\Http\Response
     */
    public function getBill($bill_id)
    {
        $bill = $this->repository->getBill($bill_id);

        return response()->json($bill, 200);
    }

    /**
     * Seta como paga uma conta
     *
     * @return \Illuminate\Http\Response
     */
    public function payBill(PayBill $request, $bill_id)
    {
        $data = [
            'paid_at' => $request->input('paymentDate')
        ];

        $this->repository->update($data, $bill_id);

        $billPaid = $this->repository->getLastBillUpdated();

        $clientModel = Client::withTrashed()->find($billPaid->client_id);
        $clientModel->sendBillPaidNotification($billPaid);

        return response()->json([
            'success' => true,
            'message' => "Conta paga!",
            'data' => $billPaid
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bill_id)
    {
        $this->repository->delete($bill_id);

        return response()->json(null, 200);
    }
}
