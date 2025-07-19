<?php

namespace App\Observers;

use App\Exceptions\OutOfStockException;
use App\Models\CartItem;
use StockChecker;

class CartItemObserver
{
    public function creating(CartItem $item)
    {
        $stock = StockChecker::checkUnitStock($item);

        if (!$stock) {
            throw new OutOfStockException("Không đủ hàng trong kho", 422, $item->unit);
        }

        $item->stock_id = $stock->id;
    }

    public function updating(CartItem $item)
    {
        // Chỉ kiểm tra lại nếu quantity hoặc unit_id thay đổi
        if ($item->isDirty(['quantity', 'unit_id'])) {
            $stock = StockChecker::checkUnitStock($item);

            if (!$stock) {
                throw new OutOfStockException("Không đủ hàng trong kho", 422, $item->unit);
            }

            $item->stock_id = $stock->id;
        }
    }
}
