<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoSequentialCharactersRule implements Rule
{
    public function passes($attribute, $value)
    {
        return !$this->hasSequentialChars($value);
    }

    public function message()
    {
        return 'The password must not contain 3 consecutive characters in the alphabet or digits.';
    }

    private function hasSequentialChars($string)
    {
        $len = strlen($string);
        for ($i = 0; $i < $len - 2; $i++) {
            if (
                (ord($string[$i + 1]) == ord($string[$i]) + 1) &&
                (ord($string[$i + 2]) == ord($string[$i]) + 2)
            ) {
                return true;
            }
        }
        return false;
    }
}