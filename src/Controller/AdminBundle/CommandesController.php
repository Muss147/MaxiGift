<?php

namespace App\Controller\AdminBundle;

use App\Entity\Commandes;
use App\Entity\Articles;
use App\Entity\Parametres;
use App\Entity\Files;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Environment;

/**
 * @Route("/backend", requirements={"_locale": "en|es|fr"})
 */
class CommandesController extends AbstractController
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
     * @Route("/e-commerce/commandes", name="commandes.list")
     */
    public function listCommandes(Request $request, Session $session): Response
    {
        $session->set('menu', 'e-commerce');
        $commandes = $this->doctrine->getRepository(Commandes::class)->findAll();
        return $this->render('backend/e-commerce/commandes.html.twig', [
            'commandes' => $commandes
        ]);
    }

    /**
     * @Route("/e-commerce/commandes/delete", name="commandes.delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCommandes(Request $request)
    {
        $em = $this->doctrine->getManager();
        foreach ($request->get('paramsDeleted') as $value) {
            $param = $em->getRepository(Articles::class)->find($value);
            $em->remove($param);
        }
        $em->flush();
        return $this->redirect($request->headers->get('referer'));
    }
}