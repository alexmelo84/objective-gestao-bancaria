<?php

namespace App\Application;

use App\Interfaces\GetItemByFieldInterface;
use App\Interfaces\GetItemInterface;

/**
 * Retrieve an item from storage based on a field
 */
class GetItemByField implements GetItemByFieldInterface
{
    /**
     * GetItemInterface $getItemInterface
     */
    private GetItemInterface $getItemInterface;

    /**
     * @var GetItemInterface $getItemInterface
     */
    public function __construct(GetItemInterface $getItemInterface)
    {
        $this->getItemInterface = $getItemInterface;
    }

    /**
     * 
     */
    public function get(): array
    {
        return $this->getItemInterface->get();
    }
}
