<?php

use App\Exceptions\OutOfStockException;
use App\Models\CartItem;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

if (!function_exists('numberToWords')) {
    function numberToWords($number)
    {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        ];

        if (!is_numeric($number)) {
            return false;
        }

        if ($number < 0) {
            return $negative . numberToWords(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = (int)($number / 100);
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . numberToWords($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = numberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= numberToWords($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = [];
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }
}

if (!function_exists('getPath')) {
    function getPath($route)
    {
        return parse_url($route, PHP_URL_PATH);
    }
}

if (!function_exists('parseDiscount')) {
    function parseDiscount($discount, $type = 'str')
    {
        switch (true) {
            case $discount > 0 && $discount <= 100:
                $result = $type === 'str' ? $discount . '%' : $discount / 100;
                break;
            case $discount > 100:
                $result = $type === 'str' ? number_format($discount) . 'đ' : $discount;
                break;
            default:
                $result = null;
                break;
        }
        return $result;
    }
}

if (!function_exists('cleanStr')) {
    function cleanStr($string)
    {
        // Loại bỏ các ký tự xuống hàng bằng Str::replace
        $string = Str::replace(array("\r", "\n"), '', $string);

        // Loại bỏ khoảng trắng thừa
        $string = preg_replace('/\s+/', ' ', $string);

        // Loại bỏ khoảng trắng ở đầu và cuối chuỗi
        $string = trim($string);

        return $string;
    }
}

if (!function_exists('parseDate')) {
    function parseDate($string)
    {
        $array = explode('/', $string);
        if (count($array) === 3) { // Nếu có đủ ngày tháng năm
            $year = $array[2];
            $month = str_pad($array[1], 2, '0', STR_PAD_LEFT);
            $day = str_pad($array[0], 2, '0', STR_PAD_LEFT);
        } else if (count($array) === 2) {
            if (strlen($array[1]) === 4) { // Nếu chỉ có năm với tháng
                $year = $array[1];
                $month = str_pad($array[0], 2, '0', STR_PAD_LEFT);
                $day = null;
            } else { // Nếu chỉ có tháng với ngày
                $year = date('Y');
                $month = str_pad($array[1], 2, '0', STR_PAD_LEFT);
                $day = str_pad($array[0], 2, '0', STR_PAD_LEFT);
            }
        } else { //Nếu chỉ có năm hoặc ngày
            if (is_numeric($array[0]) && strlen($array[0]) === 4) {
                $year = $array[1];
                $month = null;
                $day = null;
            } else if (is_numeric($array[0]) && strlen($array[0]) === 2) {
                $year = date('Y');
                $month = date('m');
                $day = str_pad($array[0], 2, '0', STR_PAD_LEFT);
            } else {
                $year = null;
                $month = null;
                $day = null;
            }
        }

        $century = floor(date('Y') / 100);
        if (strlen($year) === 2) {
            $year = ($century * 100) + $year; // Thêm thế kỷ vào năm
        }

        return ['year' => $year, 'month' => $month, 'day' => $day];
    }
}

if (!function_exists('log_exception')) {
    function log_exception($e)
    {
        Log::error(
            'An error occurred: ' . $e->getMessage() . ';' . PHP_EOL .
                'Request URL: "' . request()->fullUrl() . '";' . PHP_EOL .
                'Received Data: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                'User ID: ' . (Auth::check() ? Auth::id() : 'Guest') . ';' . PHP_EOL .
                'Error Code: ' . $e->getCode() . ';' . PHP_EOL .
                'Error Details: ' . $e->getTraceAsString()
        );
    }
}


class StockChecker
{
    public function checkUnitStock(CartItem $item): bool
    {
        $requiredQty = $item->quantity;
        $unit = $item->unit;
        if (!$unit || $unit->getSumStock() < $requiredQty) {
            return false;
        }

        // Kiểm tra xem có stock đủ hàng không (FIFO)
        return true;  
    }

    public function allocateStockForUnit($unit_id, $quantity, $userLat = null, $userLng = null)
    {
        $query = Stock::query()
            ->whereHas('import_detail', fn($q) => $q->where('unit_id', $unit_id))
            ->where('stocks.quantity', '>', 0)
            ->select([
                'stocks.id as stock_id',
                'stocks.quantity',
                'stocks.expired',
                'warehouses.id as warehouse_id',
                'warehouses.address as warehouse_address',
            ])
            ->join('import_details', 'stocks.import_detail_id', '=', 'import_details.id')
            ->join('imports', 'import_details.import_id', '=', 'imports.id')
            ->join('warehouses', 'imports.warehouse_id', '=', 'warehouses.id');

        $allocated_to_warehouse_id = optional(
            Auth::user()->cart->items->firstWhere('allocated_to_warehouse_id', '!=', null)
        )->allocated_to_warehouse_id;
        $hasCoordinates = (!is_null($userLat) && !is_null($userLng)) || !is_null($allocated_to_warehouse_id);
        $nearestWarehouseId = null;

        if ($hasCoordinates) {
            $stocksWithDistance = $query->get()->map(function ($stock) use ($userLat, $userLng) {
                [$lat, $lng] = $this->getCoordinatesFromJson($stock->warehouse_address, $stock->stock_id);

                if ($lat === 0 && $lng === 0) {
                    // Gắn khoảng cách lớn để đẩy về cuối danh sách
                    $stock->distance = 999999;
                } else {
                    $stock->distance = $this->haversine($userLat, $userLng, $lat, $lng);
                }

                return $stock;
            })->sortBy('distance')->values();

            $nearestWarehouseId = optional($stocksWithDistance->first())->warehouse_id;
            $stocks = $stocksWithDistance;
        } else {
            $stocks = $query->orderBy('stocks.expired', 'asc')->get();
        }

        $allocations = [];
        $remaining = $quantity;

        foreach ($stocks as $stock) {
            if ($remaining <= 0) break;

            $take = min($remaining, $stock->quantity);

            $allocations[] = [
                'warehouse_id'              => $stock->warehouse_id,
                'stock_id'                  => $stock->stock_id,
                'quantity'                  => (float) $take,
                'allocated_to_warehouse_id' => ($hasCoordinates && $stock->warehouse_id !== $nearestWarehouseId) ? $nearestWarehouseId : $allocated_to_warehouse_id,
            ];

            $remaining -= $take;
        }

        if ($remaining > 0) {
            throw new OutOfStockException("Sản phẩm không đủ hàng trong kho");
        }

        return $allocations;
    }

    private function getCoordinatesFromJson($json, $stockId = null)
    {
        try {
            $decoded = json_decode($json);

            if (json_last_error() !== JSON_ERROR_NONE || !is_object($decoded)) {
                return [0, 0];
            }

            $lat = $decoded->lat ?? 0;
            $lng = $decoded->lng ?? 0;

            return [(float) $lat, (float) $lng];
        } catch (\Throwable $e) {
            return [0, 0];
        }
    }


    protected function haversine($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // km
        $latFrom = deg2rad($lat1);
        $latTo = deg2rad($lat2);
        $lngDiff = deg2rad($lng2 - $lng1);
        $a = sin(($latTo - $latFrom) / 2) ** 2 +
            cos($latFrom) * cos($latTo) * sin($lngDiff / 2) ** 2;
        return $earthRadius * 2 * asin(sqrt($a));
    }
}
class GenerateMessage
{
    public function gener_response($message)
    {
        switch ($message->action) {
            case 'text':
                return $message->text;
        }
        return $message;
    }
}
