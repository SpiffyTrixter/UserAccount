<?php

namespace UserAccount\Validator;

use Exception;
use UserAccount\Entity\User;
use UserAccount\Exception\ValidationException;

final class UserValidator
{
    /**
     * @throws Exception
     */
    public function validate(User $user)
    {
        if ($user->getEmail()) {
            if(!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
                throw new ValidationException(sprintf('UserValidation [email]: %s is not valid!',- $user->getEmail()));
            }
        } else {
            throw new ValidationException('UserValidation [email]: is requierd');
        }

        if (!$user->getPassword()) {
            throw new ValidationException('UserValidation [password]: is requierd');
        }
    }
}
