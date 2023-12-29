<?php
namespace App\Factory\AccountFactory;
use App\Factory\AccountFactory\StandardManager;
use Controllers\Helper;

class StandardFactory extends AccountFactory
{
    // Unlike Redis, we will need an array of data to connect
    public function __construct(public $router, public $APIkey)
    {

    }

    // Concrete Factory Method Implementation
    public function getBusinessManager(): IBusinessManager
    {
        return new StandardManager($this->router, $this->APIkey);
    }
}