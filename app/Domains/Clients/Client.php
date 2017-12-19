<?php

namespace App\Domains\Clients;

use App\Notifications\BillCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = ['name', 'email'];
    //protected $nullable = ['email'];


    public function sendBillCreatedNotification($bill)
    {
        $this->notify(new BillCreated($bill));
    }

    public function bills()
    {
        return $this->hasMany('App\Domains\Bills\Bill');
    }
}
