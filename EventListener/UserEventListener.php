<?php
namespace SbS\AdminLTEBundle\EventListener;

use SbS\AdminLTEBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserEventListener
{
    private $token_storage;

    public function __construct(TokenStorageInterface $token_storage)
    {
        $this->token_storage = $token_storage;
    }

    public function getUser()
    {
        /** @var UserInterface $user */
        $user = $this->token_storage->getToken()->getUser();

        return $user;
    }
}
