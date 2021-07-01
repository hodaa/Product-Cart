<?php

namespace  App\Composite;

use App\Contracts\BillInterface;

class Bill implements BillInterface
{
    private array $elements =[];

    /**
     * @return string
     */
    public function Print(): string
    {
        $total= '';
        foreach ($this->elements as $element) {
            $total .= $element->print();
        }
        return $total;
    }

    public function addElement(BillInterface $element)
    {
        $this->elements[] = $element;
    }

}
