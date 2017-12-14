<?php

namespace App\Domains\BillTypes\Repositories;

use App\Domains\BillTypes\BillType;
use App\Repositories\Eloquent\Repository;

class BillTypeRepository extends Repository
{
    protected $modelClass = BillType::class;
}