<?php

namespace UserAccount\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;
use Exception;
use UserAccount\Entity\User;
use UserAccount\Validator\UserValidator;
use RuntimeException;

final class UserRepository
{
    private EntityManager $em;
    private UserValidator $uv;

    public function __construct(EntityManager $entityManager, UserValidator $userValidator)
    {
        $this->em = $entityManager;
        $this->uv = $userValidator;
    }

    /**
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    public function getUser(int $id)
    {
        $user = $this->em->find(User::class, $id);
        if (!$user) {
            throw new RuntimeException(sprintf('Could not find row with identifier %d', $id));
        }
        return $user;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws Exception
     */
    public function saveUser(User $user)
    {
        $this->uv->validate($user);
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteUser(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }
}
