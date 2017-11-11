<?php

namespace App\Domains\Clients\Repositories;

use App\Domains\Clients\Client;
use App\Repositories\Eloquent\Repository;

class ClientRepository extends Repository
{
    protected $modelClass = Client::class;
}