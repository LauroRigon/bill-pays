<?php

namespace App\Domains\Bills;

use App\Domains\Clients\Client;
use App\Domains\BillTypes\BillType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Bill extends Model
{
    protected $fillable = ['client_id', 'description', 'bill_type_id', 'price', 'expire_date'];

    protected $dates = ['created_at',
                        'updated_at',
                        'deleted_at'];

    public function __contruct()
    {
        $this->setDateFormat("d-m-Y");
    }

    public function client()
    {
        return $this->belongsTo(Client::class)->withTrashed();
    }

    public function bill_type()
    {
        return $this->belongsTo(BillType::class)->withTrashed();
    }

    public function getExpireDateAttribute($date)
    {
        $newDate = $this->asDate($date);

        return $newDate->format('d-m-Y');
    }

    public function getPaidAtAttribute($date)
    {
        if($date !== null) {
            $newDate = $this->asDate($date);

            return $newDate->format('d-m-Y');
        }else{
            return $date;
        }
    }
}
