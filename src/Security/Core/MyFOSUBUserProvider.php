<?php

namespace App\Security\Core;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;

class MyFOSUBUserProvider extends BaseFOSUBProvider
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        UserManagerInterface $userManager,
        array $properties,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($userManager, $properties);
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $userEmail = $response->getEmail();
        /** @var User $user */
        $user      = $this->userManager->findUserByEmail($userEmail);

        // if null just create new user and set it properties
        if (null === $user) {
            $username = $response->getNickname();
            $user     = new User();
            $user->setUsername($username);
            $user->setEmail($userEmail);
            $user->setPassword($username);
            $user->setEnabled(true);
            $user->setGithubId($response->getUsername());
            $this->setUserAccessToken($response, $user);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $user;
        }

        $user->setGithubId($response->getUsername());
        $this->setUserAccessToken($response, $user);

        return $user;
    }

    /**
     * @param UserResponseInterface $response
     * @param UserInterface         $user
     */
    private function setUserAccessToken(UserResponseInterface $response, UserInterface $user): void
    {
        $serviceName = $response->getResourceOwner()->getName();
        $setter      = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->$setter($response->getAccessToken());//update access token
    }
}
