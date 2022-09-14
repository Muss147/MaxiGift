<?php

namespace App\Controller\AdminBundle;

use App\Entity\Entreprises;
use App\Entity\Users;
use App\Entity\Files;
use App\Entity\Roles;
use App\Entity\Parametres;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Environment;

/**
 * @Route("/backend", requirements={"_locale": "en|es|fr"})
 */
class EntreprisesController extends AbstractController
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
     * @Route("/entreprises/view-{id}", name="entreprises.view")
     */
    public function viewEntreprises(Session $session, Entreprises $entreprise): Response
    {
        $session->set('menu', 'entreprise');
        $secteursActivite = $this->doctrine->getRepository(Parametres::class)->findByType("Secteurs d'activité");
        return $this->render('backend/entreprises/detail.html.twig', [
            'entreprise' => $entreprise,
            'secteursActivite' => $secteursActivite,
        ]);
    }

    /**
     * @Route("/entreprises-list", name="entreprises.list")
     */
    public function listEntreprises(Session $session): Response
    {
        $session->set('menu', 'entreprise');
        $em = $this->doctrine->getManager();
        $entreprises = $em->getRepository(Entreprises::class)->findAll();
        $secteursActivite = $em->getRepository(Parametres::class)->findByType("Secteurs d'activité");
        return $this->render('backend/entreprises/list.html.twig', [
            'entreprises' => $entreprises,
            'secteursActivite' => $secteursActivite,
        ]);
    }

    /**
     * @Route("/entreprises-new", name="entreprises.new")
     */
    public function newEntreprises(Request $request, FileUploader $fileUploader): Response
    {
        $em = $this->doctrine->getManager();
        $id = $request->get('id');
        $entreprise = new Entreprises();
        if($id) $entreprise = $em->getRepository(Entreprises::class)->find($id);

        if ($request->isMethod('POST')) {
            $name = $request->get("name");
            $registre = $request->get("registre");
            $secteur = $em->getRepository(Parametres::class)->find($request->get("secteur"));
            $nomContact = $request->get("nomContact");
            $prenomContact = $request->get("prenomContact");
            $emailContact = $request->get("emailContact");
            $tel = $request->get("tel");
            $fixe = $request->get("fixe");
            $adresse = $request->get("adresse") ?? null;
            $commune = $request->get("commune") ?? null;
            $ville = $request->get("ville") ?? null;
            $pays = $request->get("pays") ?? null;
            $description = $request->get("description");

            $entreprise->setNom($name)
                ->setRegistreCommerce($registre)
                ->setSecteurActivite($secteur)
                ->setNomContact($nomContact)
                ->setPrenomContact($prenomContact)
                ->setEmail($emailContact)
                ->setTel($tel)
                ->setFixe($fixe)
                ->setAdresse($adresse)
                ->setCommune($commune)
                ->setVille($ville)
                ->setPays($pays)
                ->setDescription($description)
                ->updatedUserstamps($this->getUser());
            $entreprise->updatedTimestamps();
            $file = $request->files->get('logo');
            if ($file) {
                $image = new Files();
                if ($entreprise->getLogo()) $image = $em->getRepository(Files::class)->find($entreprise->getLogo()->getId());
                $fileName = $fileUploader->upload($file);
                $image->setTempFile($fileName)->setAlt($name);
                $em->persist($image);
                $entreprise->setLogo($image);
            }
            $em->persist($entreprise);
            $em->flush();
        }
        if ($id) return $this->redirectToRoute('entreprises.view', ['id' => $entreprise->getId()]);
        else return $this->redirectToRoute('entreprises.list');
    }

    /**
     * @Route("/entreprises/delete", name="entreprises.delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteEntreprises(Request $request)
    {
        $em = $this->doctrine->getManager();
        foreach ($request->get('entreprisesDeleted') as $value) {
            $entreprise = $em->getRepository(Entreprises::class)->find($value);
            $em->remove($entreprise);
        }
        dd($request->get('entreprisesDeleted'));
        $em->flush();
        return $this->redirectToRoute('entreprises.list');
    }

}