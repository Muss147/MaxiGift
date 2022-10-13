<?php

namespace App\Controller\AdminBundle;

use App\Entity\Users;
use App\Entity\Entreprises;
use App\Entity\Enquetes;
use App\Entity\Roles;
use App\Entity\Files;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig\Environment;

/**
 * @Route("/backend", requirements={"_locale": "en|es|fr"})
 */
class UsersController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(Environment $twig, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine) {
        $this->twig = $twig;
        $this->passwordHasher = $passwordHasher;
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/users/preview-{id}", name="users.view")
     * @param Users $user
     */
    public function viewUser(Session $session, Users $user): Response
    {
        $session->set('menu', 'user');
        // if ($user == $this->getUser()) $session->set('menu', 'account');
        $em = $this->doctrine->getManager();
        $enquetes = $em->getRepository(Enquetes::class)->findAll();
        return $this->render('backend/users/view.html.twig', [
            'user' => $user,
            'enquetes' => $enquetes
        ]);
    }

    /**
     * @Route("/users-list", name="users.list")
     */
    public function usersList(Request $request, Session $session): Response
    {
        $session->set('menu', 'user');
        $em = $this->doctrine->getManager();
        $listUsers = $em->getRepository(Users::class)->findAll();
        return $this->render('backend/users/list.html.twig', [
            'users' => $listUsers,
        ]);
    }

    /**
     * @Route("/users/check-email", name="users.checkEmail")
     */
    public function usersCheckEmail(Request $request): Response
    {
        $response = false;
        $email = $request->get('email');
        if ($check = $this->doctrine->getRepository(Users::class)->findOneByEmail($email)) $response = true;
        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/users/update-{id}", name="users.update")
     */
    public function updateUser(Request $request, Users $user, FileUploader $fileUploader): Response
    {
        $em = $this->doctrine->getManager();
        if ($request->isMethod('POST')) {
            $firstname = $request->get("fname");
            $lastname = $request->get("lname");
            $birth = new \dateTime($request->get("birth"));
            $contact = $request->get("contact");
            $adresse = $request->get("adresse");
            $commune = $request->get("commune");
            $ville = $request->get("ville");
            $pays = $request->get("pays");
            $email = $request->get("email");
            $password = $request->get("password");
            $user_role = $request->get("user_role");
            
            if ($email) $user->setEmail($email);
            if ($password) $user->setPassword($this->passwordHasher->hashPassword($user, $password));
            if ($firstname) $user->setFirstname($firstname);
            if ($lastname) $user->setLastname($lastname);
            if ($adresse) $user->setAdresse($adresse);
            if ($commune) $user->setCommune($commune);
            if ($ville) $user->setVille($ville);
            if ($pays) $user->setPays($pays);
            if ($birth) $user->setBirth($birth);
            if ($contact) $user->setContact($contact);
            $user->updatedUserstamps($this->getUser());
            $user->updatedTimestamps();
            
            $user->updatedUserstamps($this->getUser());
            $user->updatedTimestamps();
            $em->persist($user);
            $em->flush();
        }
        return $this->redirectToRoute('users.view', ['id' => $user->getId()]);
    }
    
    /**
     * @Route("/users-delete", name="users.delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteUsers(Request $request)
    {
        $em = $this->doctrine->getManager();
        foreach ($request->get('usersDeleted') as $value) {
            $user = $em->getRepository(Users::class)->find($value);
            $em->remove($user);
        }
        $em->flush();
        return $this->redirectToRoute('users.list');
    }
}