<?php

namespace App\Domains\Clients;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'email'];
    //protected $nullable = ['email'];
}
