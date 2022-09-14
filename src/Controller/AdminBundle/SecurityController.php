<?php
namespace App\Controller\AdminBundle;

use App\Entity\Admins;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\Persistence\ManagerRegistry;

class SecurityController extends AbstractController {

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }
    
    /**
     * @Route("/backend/login", name="backend_login")
     */
    public function usersLogin(AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $user = $this->getUser();
        // if ($user) return $this->redirectToRoute('admin');

        return $this->render('backend/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

}