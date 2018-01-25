<?php

namespace App\Domains\Bills\Repositories;

use App\Domains\Bills\Bill;
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

    public function getLastBillUpdated() {
        return $this->model->orderBy('updated_at')->first();
    }

    public function getFilterdBills($data) {
        $query = $this->model;

        //Add where clausule to bill type selected
        if(isset($data['bill_type'])) {
            $query = $query->where('bill_type_id', '=', $data['bill_type']);
        }

        //Verify if is any client selected, if so, add where conditions with clients
        if(!empty($data['clients'])){
            //add an 'and' condition and grouping '()' to next conditions
            $query = $query->where(function ($query) use ($data) {
                foreach ($data['clients'] as $client) {
                    //add or conditions
                    $query->orWhere('client_id', '=', $client);
                }
            });
        }

        if(isset($data['paiment_situation'])) {
            if($data['paiment_situation'] == 'only_paid') {
                $query->whereNotNull('paid_at');
            }

            if($data['paiment_situation'] == 'only_not_paid') {
                $query->whereNull('paid_at');
            }
        }

        /*
         * Falta a parte da situação das contas e bug no tipo de conta
         * */

        //If there is expire date from, add date conditions on expire date column
        if(isset($data['expire_date_from']) && isset($data['expire_date_to'])) {
            $query = $query->whereDate('expire_date', ">=", $data['expire_date_from'])->whereDate('expire_date', "<=", $data['expire_date_to']);
        }

        if(isset($data['pay_date_from']) && isset($data['pay_date_to'])) {
            $query = $query->whereDate('paid_at', ">=", $data['pay_date_from'])->whereDate('paid_at', "<=", $data['pay_date_to']);
        }

        //If deleted bills option is true, add withTrashed chain
        if($data['bills_deleted']) {
            $query = $query->withTrashed();
        }

        return $query->with(['client', 'bill_type'])->get();
    }
}