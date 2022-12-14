<?php
namespace App\Service;

use Symfony\Component\Security\Core\Security;

class GetCurrentUser
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    public function currentUser()
    {
        // returns User object or null if not authenticated
        $user = $this->security->getUser();
        return $user;
    }
}
