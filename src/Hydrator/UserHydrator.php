<?php

namespace UserAccount\Hydrator;

use Google\Service\Oauth2\Userinfo;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use UserAccount\Entity\User;

final class UserHydrator
{
    public function hydrate(array $data, User $user)
    {
        $user->setEmail($data['email'] ?? null);
        $user->setUsername($data['username'] ?? null);
        $user->setPassword(isset($data['password']) ? password_hash($data['password'], PASSWORD_BCRYPT) : null);
        $user->setLastname($data['lastname'] ?? null);
        $user->setFirstname($data['firstname'] ?? null);
    }

    public function hydrateFromGoogleUser(Userinfo $userinfo, User $user)
    {
        $user->setEmail($userinfo->getEmail());
        $user->setUsername($userinfo->getName());
        $user->setPassword(null);
        $user->setLastname($userinfo->getFamilyName());
        $user->setFirstname($userinfo->getGivenName());
        $user->setGoogleId($userinfo->getId());
    }

    #[Pure] #[ArrayShape([
        'id' => "int",
        'email' => "string",
        'username' => "string",
        'password' => "null|string",
        'lastname' => "string",
        'firstname' => "string"
    ])] public function extract(User $user): array
    {
        return [
            'id' => $user->getId() ?? null,
            'email' => $user->getEmail() ?? null,
            'username' => $user->getUsername() ?? null,
            'password' => $user->getPassword() ?? null,
            'lastname' => $user->getLastname() ?? null,
            'firstname' => $user->getFirstname() ?? null
        ];
    }
}
