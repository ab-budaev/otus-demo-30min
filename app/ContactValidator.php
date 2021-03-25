<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\InvalidEmailException;

class ContactValidator
{
    /**
     * @param string $email
     * @throws InvalidEmailException
     */
    public function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }
    }
}
