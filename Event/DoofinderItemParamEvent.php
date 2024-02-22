<?php

namespace Doofinder\Event;

use Thelia\Core\Event\ActionEvent;

class DoofinderItemParamEvent extends ActionEvent
{
    public array $itemParam;

    /**
     * @param array $itemParam
     */
    public function __construct(array $itemParam)
    {
        $this->itemParam = $itemParam;
    }

    public function getItemParam(): array
    {
        return $this->itemParam;
    }

    public function setItemParam(array $itemParam): DoofinderItemParamEvent
    {
        $this->itemParam = $itemParam;
        return $this;
    }
}