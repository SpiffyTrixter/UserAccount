<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;
use UserAccount\Entity\User;
use UserAccount\Hydrator\UserHydrator;
use UserAccount\Service\Google\GoogleService;

/**
 * @var string $step
 * @var EntityManager $entityManager
 */

$googleService = new GoogleService();
$googleAuthentication = $googleService->getGoogleAuthentication();
$client = $googleService->getGoogleClient();

$userHydrator = new UserHydrator();

switch($step) {
    case 'email':
        $link = $client->createAuthUrl();
        break;
    case 'password':
        break;
    case 'redirect':
        $googleUserData = $googleAuthentication->getUserData($_GET['code']);

        $user = $entityManager->getRepository(User::class)->findOneBy(['google_id' => $googleUserData->getId()]);

        if (!$user) {
            $user = new User();
        }

        $userHydrator->hydrateFromGoogleUser($googleUserData, $user);

        try {
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (OptimisticLockException|ORMException $e) {
            echo $e->getMessage();
        }
        break;
}
