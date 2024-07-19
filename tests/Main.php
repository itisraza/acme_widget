<?php

class Main
{
    private $catalog;
    private $deliveryChargeRules;

    protected function __construct()
    {
        $this->catalog = array(
            new Product('R01', 'Red Widget', 32.95),
            new Product('G01', 'Green Widget', 24.95),
            new Product('B01', 'Blue Widget', 7.95)
        );

        $this->deliveryChargeRules = array(
            new DeliveryChargeRule(50, 4.95),
            new DeliveryChargeRule(90, 2.95)
        );
    }

    public function testTotals()
    {
        $basket = new Basket($this->catalog, $this->deliveryChargeRules);

        $basket->add('B01');
        $basket->add('G01');
        print($basket->total()); // this should output $37.85 = $7.95 + $24.95 + $4.95(Delivery)

        $basket = new Basket($this->catalog, $this->deliveryChargeRules);
        $basket->add('R01');
        $basket->add('R01');
        print($basket->total()); // this should output $54.37 = $32.95 + $16.47 + $4.95(Delivery)

        $basket = new Basket($this->catalog, $this->deliveryChargeRules);
        $basket->add('R01');
        $basket->add('G01');
        print($basket->total()); // this should output $60.85 = $32.95 + $24.95 + $2.95(Delivery)

        $basket = new Basket($this->catalog, $this->deliveryChargeRules);
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');
        print($basket->total()); // this should output $98.27 = $7.95 + $7.95 + $32.95 + $16.47 + $32.95 + 0(Delivery)
    }
}
