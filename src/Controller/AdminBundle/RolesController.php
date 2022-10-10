<?php

namespace App\Controller\AdminBundle;

use App\Entity\Roles;
use App\Entity\Autorisations;
use App\Entity\Permissions;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig\Environment;

/**
 * @Route("/backend", requirements={"_locale": "en|es|fr"})
 */
class RolesController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(Environment $twig, ManagerRegistry $doctrine) {
        $this->twig = $twig;
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/roles/view-{slug}", name="roles.view")
     */
    public function viewRole(Request $request, Roles $role, Session $session): Response
    {
        $session->set('menu', 'admin');
        return $this->render('backend/roles/view.html.twig', [
            'role' => $role
        ]);
    }

    /**
     * @Route("/roles-list", name="roles.list")
     */
    public function rolesList(Request $request, Session $session): Response
    {
        $session->set('menu', 'admin');
        $em = $this->doctrine->getManager();
        $listRoles = $em->getRepository(Roles::class)->findBy([], ['libelle' => 'ASC']);
        $autorisations = $em->getRepository(Autorisations::class)->findAll();
        return $this->render('backend/roles/list.html.twig', [
            'roles' => $listRoles,
            'autorisations' => $autorisations
        ]);
    }

    /**
     * @Route("/roles/find-{id}", name="roles.find")
     */
    public function findRole(Request $request, Roles $role): Response
    {
        $response['id'] = $role->getId();
        $response['libelle'] = $role->getLibelle() ?? "";
        $response['all'] = $role->isAllAdminAccess();
        $response['description'] = $role->getDescription() ?? "";
        $response['permissions'] = [];
        foreach ($role->getPermissions() as $permis) {
            $permission['autoris']['id'] = "";
            $permission['autoris']['libelle'] = "";
            if ($permis->getAutorisation()) {
                $permission['autoris']['id'] = $permis->getAutorisation()->getId();
                $permission['autoris']['libelle'] = $permis->getAutorisation()->getLibelle();
            }
            $permission['lecture'] = $permis->isLecture();
            $permission['ecriture'] = $permis->isEcriture();
            $permission['creation'] = $permis->isCreation();
            array_push($response['permissions'], $permission);
        }
        return new JsonResponse($response, 200);
    }

    /**
     * @Route("/roles-new", name="roles.new")
     */
    public function newRole(Request $request): Response
    {
        $em = $this->doctrine->getManager();
        $id = $request->get('id');
        $role = new Roles();
        if ($id) $role = $em->getRepository(Roles::class)->find($id);

        if ($request->isMethod('POST')) {
            $role_name = $request->get('role_name');
            $role_descr = $request->get('role_descr');
            $autoris = $request->get('autoris') ?? [];
            $read = $request->get('read') ?? [];
            $write = $request->get('write') ?? [];
            $create = $request->get('create') ?? [];
            $all = $request->get('all') ?? false;

            $role->setLibelle($role_name)->setSlug('ROLE_'.strtoupper($role_name))->setDescription($role_descr)->setAllAdminAccess($all)->updatedUserstamps($this->getUser());
            $role->updatedTimestamps();
            $em->persist($role);
            foreach ($autoris as $index => $autorisId) {
                $autorisation = $em->getRepository(Autorisations::class)->find($autorisId);
                $rolePermissions = $role->getPermissions();
                $permission = $rolePermissions[$index];
                if (!$permission) $permission = new Permissions();

                $permission->setLecture($read[$index])->setEcriture($write[$index])->setCreation($create[$index])->setAutorisation($autorisation)->setRole($role)->updatedUserstamps($this->getUser());
                $permission->updatedTimestamps();
                $em->persist($permission);
            }
            $em->flush();
        }
        if ($id) return $this->redirectToRoute('roles.view', ['slug' => $role->getSlug()]);
        else return $this->redirectToRoute('roles.list');
    }

    /**
     * @Route("/roles/delete-{id}", name="roles.delete")
     * @param Roles $role
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteRole(Roles $role, Request $request)
    {
        $em = $this->doctrine->getManager();
        $em->remove($role);
        $em->flush();
        return $this->redirectToRoute('roles.list');
    }

    /**
     * @Route("/autorisations", name="autorisations")
     */
    public function autorisations(Request $request, Session $session): Response
    {
        $session->set('menu', 'admin');
        $em = $this->doctrine->getManager();
        $id = $request->get('id');
        $autorisation = new Autorisations();
        if ($id) $autorisation = $em->getRepository(Autorisations::class)->find($id);

        if ($request->isMethod('POST')) {
            $name = $request->get('name');
            $core = $request->get('core') ?? false;

            $autorisation->setLibelle($name)->setCore($core)->updatedUserstamps($this->getUser());
            $autorisation->updatedTimestamps();
            $em->persist($autorisation);
            $em->flush();
        }

        $autorisations = $em->getRepository(Autorisations::class)->findAll();
        return $this->render('backend/roles/autorisations.html.twig', [
            'autorisations' => $autorisations
        ]);
    }

    /**
     * @Route("/autorisations/delete-{id}", name="autorisations.delete")
     * @param Autorisations $autoris
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCompany(Autorisations $autoris, Request $request)
    {
        $em = $this->doctrine->getManager();
        $em->remove($autoris);
        $em->flush();
        return $this->redirectToRoute('autorisations');
    }

}