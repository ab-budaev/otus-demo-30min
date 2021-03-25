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
        $matchesEmailPattern = preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email);

        if (!$matchesEmailPattern) {
            throw new InvalidEmailException();
        }
    }
}
