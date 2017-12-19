<?php

namespace App\Domains\Bills\Repositories;

use App\Domains\BillTypes\Bill;
use App\Repositories\Eloquent\Repository;
use Illuminate\Notifications\ChannelManager;
use App\Domains\Clients\Client;
class BillRepository extends Repository
{
    protected $modelClass = Bill::class;

    public function storeManyBills($data)
    {
        $clients = $data['clients'];

        foreach ($clients as $client){
            $storeData = [
                'client_id' => $client,
                'description' =>  $data['description'],
                'bill_type_id' =>  $data['type'],
                'price' =>  $data['price'],
                'expire_date' =>  $data['expire_date']
            ];

            $billCreated = $this->create($storeData);

            $clientModel = Client::find($client);
            $clientModel->sendBillCreatedNotification($billCreated);
        }
    }

    public function getAllExpireds() {
        return $this->model->whereDate('expire_date', "<", date("Y-m-d"))->where('paid_at', '=', null)->with(['client', 'bill_type'])->get();
    }

    public function getAllNotExpireds() {
        return $this->model->whereDate('expire_date', ">=", date("Y-m-d"))->where('paid_at', '=', null)->with(['client', 'bill_type'])->get();
    }

    public function getBill($id) {
        return $this->model->where('id', "=",  $id)->with(['client', 'bill_type'])->first();
    }
}