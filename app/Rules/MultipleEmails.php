<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MultipleEmails implements Rule
{
    public function passes($attribute, $value)
    {
        // Separa por vírgula e valida cada e-mail
        $emails = array_map('trim', explode(',', $value));
        foreach ($emails as $email) {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }
        return true;
    }

    public function message()
    {
        return 'Um ou mais e-mails informados são inválidos.';
    }
}
