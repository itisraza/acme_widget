<?php

class DeliveryChargeRule
{
    public $threshold;
    public $charge;

    public function __construct($threshold, $charge)
    {
        $this->threshold = $threshold;
        $this->charge = $charge;
    }
}
