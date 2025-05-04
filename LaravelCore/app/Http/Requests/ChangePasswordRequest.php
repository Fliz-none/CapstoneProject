<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\NoSequentialCharactersRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[0-9]/', // At least one digit
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[@$!%*?&#]/', // At least one special character
                function ($attribute, $value, $fail) {
                    $user = User::find($this->id);
                    if (Hash::check($value, $user->password)) {
                        $fail('The new password must not be the same as the current password.');
                    }
                },
                new NoSequentialCharactersRule, // Custom rule to check for sequential characters
            ],
        ];
    }

    public function messages()
    {
        return [
            'password.different' => 'The new password must not be the same as the current password.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.regex' => 'The password must contain at least one digit, one uppercase letter, one lowercase letter, and one special character.',
        ];
    }
}
