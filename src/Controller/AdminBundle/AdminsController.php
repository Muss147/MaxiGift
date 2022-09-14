<?php

namespace App\Controller\AdminBundle;

use App\Entity\Admins;
use App\Entity\Roles;
use App\Entity\Entreprises;
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
class AdminsController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(Environment $twig, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine) {
        $this->twig = $twig;
        $this->passwordHasher = $passwordHasher;
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/", name="dash")
     */
    public function index(Session $session): Response
    {
        $session->set('menu', 'dash');
        $em = $this->doctrine->getManager();

        // $packages = $em->getRepository(Packages::class)->allPackages();

        return $this->render('backend/dash.html.twig', [
            // 'packages' => $packages
        ]);
    }

    /**
     * @Route("/admins/view-{id}", name="admins.view")
     */
    public function adminVew(Request $request, Session $session, Admins $admin): Response
    {
        $session->set('menu', 'admin');
        $em = $this->doctrine->getManager();
        $listAdmins = $em->getRepository(Admins::class)->findAll();
        $listRoles = $em->getRepository(Roles::class)->findAll();
        $entreprises = $em->getRepository(Entreprises::class)->findAll();
        return $this->render('backend/admins/overview.html.twig', [
            'admin' => $admin,
            'admins' => $listAdmins,
            'roles' => $listRoles,
            'entreprises' => $entreprises,
        ]);
    }

    /**
     * @Route("/admins-list", name="admins.list")
     */
    public function adminList(Request $request, Session $session): Response
    {
        $session->set('menu', 'admin');
        $em = $this->doctrine->getManager();
        $listAdmins = $em->getRepository(Admins::class)->findAll();
        $roles = $em->getRepository(Roles::class)->findBy([], ['id' => 'DESC']);

        return $this->render('backend/admins/list.html.twig', [
            'admins' => $listAdmins,
            'roles' => $roles,
        ]);
    }

    /**
     * @Route("/admins-new", name="admins.new")
     */
    public function adminNew(Request $request, FileUploader $fileUploader): Response
    {
        $em = $this->doctrine->getManager();
        $id = $request->get('id');
        $admin = new Admins();
        if ($id) $admin = $em->getRepository(Admins::class)->find($id);

        if ($request->isMethod('POST')) {
            if ($request->get("fname")) $admin->setFirstname($request->get("fname"));
            if ($request->get("lname")) $admin->setLastname($request->get("lname"));
            if ($request->get("email")) $admin->setEmail($request->get("email"));
            if ($request->get("contact")) $admin->setContact($request->get("contact"));
            if ($request->get("password")) $admin->setPassword($this->passwordHasher->hashPassword($admin, $request->get("password")));
            if ($request->get("user_role")) {
                $role = $em->getRepository(Roles::class)->find($request->get("user_role"));
                $admin->setRoles($role);
            }
            if ($request->get("user_company")) {
                $company = $em->getRepository(Entreprises::class)->find($request->get("user_company"));
                $admin->setEntreprise($company);
            }
            if ($request->get("activate") && $admin->isActivate()) $admin->setActivate(false);
            else $admin->setActivate(true);
            
            $admin->updatedUserstamps($this->getUser());
            $admin->updatedTimestamps();
            $file = $request->files->get('avatar');
            if ($file) {
                $image = new Files();
                if ($admin->getAvatar()) $image = $em->getRepository(Files::class)->find($admin->getAvatar()->getId());
                $fileName = $fileUploader->upload($file);
                $image->setTempFile($fileName)->setAlt($firstname." ".$lastname);
                $em->persist($image);
                $admin->setAvatar($image);
            }
            $em->persist($admin);
            $em->flush();
            // $this->addFlash('msgNotice', 'Form has been successfully submitted!');
        }
        if ($id) return $this->redirectToRoute('admins.view', ['id' => $admin->getId()]);
        else return $this->redirectToRoute('admins.list');
    }

    /**
     * @Route("/admin/check-email", name="admins.checkEmail")
     */
    public function checkEmail(Request $request): Response
    {
        $response = false;
        $email = $request->get('email');
        if ($check = $this->doctrine->getRepository(Admins::class)->findOneByEmail($email)) $response = true;
        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/admin/check-pswd", name="admins.checkPswd")
     */
    public function checkPswd(Request $request): Response
    {
        $response = false;
        $admin = $this->doctrine->getRepository(Admins::class)->find($request->get('id'));
        $pswd = $this->passwordHasher->hashPassword($admin, $request->get('pswd'));
        if ($pswd == $admin->getPassword()) $response = true;
        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/admins/delete", name="admins.delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAdmin(Request $request)
    {
        $em = $this->doctrine->getManager();
        foreach ($request->get('adminDeleted') as $value) {
            $admin = $em->getRepository(Admins::class)->find($value);
            $em->remove($admin);
        }
        $em->flush();
        return $this->redirectToRoute('admins.list');
    }

}