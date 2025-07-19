<?php

namespace App\Exceptions;

use App\Models\Unit;
use Exception;

class OutOfStockException extends Exception
{
    public function __construct($message = "Không đủ hàng trong kho ", $code = 0, ?Unit $unit = null)
    {
        parent::__construct($message . ($unit ? '(' . optional($unit->variable)->fullName . ' - ' . $unit->term . ')' : ''), $code);
    }
}
