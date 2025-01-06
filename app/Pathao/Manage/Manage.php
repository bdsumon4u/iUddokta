<?php

namespace App\Pathao\Manage;

use App\Pathao\Apis\AreaApi;
use App\Pathao\Apis\OrderApi;
use App\Pathao\Apis\StoreApi;

class Manage
{
    /**
     * @var AreaApi
     */
    private $area;

    /**
     * @var StoreApi
     */
    private $store;

    /**
     * @var OrderApi
     */
    private $order;

    public function __construct(AreaApi $areaApi, StoreApi $storeApi, OrderApi $orderApi)
    {
        $this->area = $areaApi;
        $this->store = $storeApi;
        $this->order = $orderApi;
    }

    public function area(): AreaApi
    {
        return $this->area;
    }

    public function store(): StoreApi
    {
        return $this->store;
    }

    public function order(): OrderApi
    {
        return $this->order;
    }
}
