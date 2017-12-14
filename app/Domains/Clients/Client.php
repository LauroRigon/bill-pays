<?php

namespace App\Domains\Clients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email'];
    //protected $nullable = ['email'];

    public function bills()
    {
        return $this->hasMany('App\Domains\Bills\Bill');
    }
}
