<?php

class Basket
{
    private $catalog;
    private $deliveryChargeRules;
    private $items = array();

    public function __construct($catalog, $deliveryChargeRules)
    {
        $this->catalog = $catalog;
        $this->deliveryChargeRules = $deliveryChargeRules;
    }

    public function add($productCode)
    {
        foreach ($this->catalog as $product) {
            if ($product->code == $productCode) {
                $this->items[] = $product;
                return;
            }
        }
    }

    public function total()
    {
        $items = $this->items;
        $items = $this->applyRedWidgetOffer($items);

        $total = 0;
        foreach ($items as $item) {
            $total += $item->price;
        }

        $deliveryCharge = $this->calculateDeliveryCharges($total);
        $total += $deliveryCharge;

        return round($total, 2);
    }

    private function calculateDeliveryCharges($total)
    {
        foreach ($this->deliveryChargeRules as $rule) {
            if ($total < $rule->threshold) {
                return $rule->charge;
            }
        }
        return 0.0;
    }

    private function applyRedWidgetOffer($products)
    {
        $redWidgets = array();
        $otherProducts = array();

        foreach ($products as $product) {
            if ($product->code == 'R01') {
                $redWidgets[] = $product;
            } else {
                $otherProducts[] = $product;
            }
        }

        $count = count($redWidgets);
        if ($count > 1) {
            for ($i = 1; $i < $count; $i += 2) {
                $redWidgets[$i]->price /= 2;
            }
        }

        return array_merge($redWidgets, $otherProducts);
    }
}
