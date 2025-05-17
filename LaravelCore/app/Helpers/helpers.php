<?php

use Illuminate\Support\Facades\Auth;
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
        Log::error('An error occurred: ' . $e->getMessage() . ';' . PHP_EOL .
                'Request URL: "' . request()->fullUrl() . '";' . PHP_EOL .
                'Received Data: ' . json_encode(request()->all()) . ';' . PHP_EOL .
                'User ID: ' . (Auth::check() ? Auth::id() : 'Guest') . ';' . PHP_EOL .
                'Error Details: ' . $e->getTraceAsString()
        );
    }
}
