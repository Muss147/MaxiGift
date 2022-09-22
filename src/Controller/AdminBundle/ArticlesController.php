<?php

namespace App\Controller\AdminBundle;

use App\Entity\Articles;
use App\Entity\Marques;
use App\Entity\Parametres;
use App\Entity\Files;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Twig\Environment;

/**
 * @Route("/backend", requirements={"_locale": "en|es|fr"})
 */
class ArticlesController extends AbstractController
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
     * @Route("/e-commerce/liste-produits", name="products.list")
     */
    public function listProducts(Request $request): Response
    {
        $listProduct = $this->doctrine->getRepository(Articles::class)->findAll();
        return $this->render('backend/e-commerce/list.html.twig', [
            'produits' => $listProduct
        ]);
    }

    /**
     * @Route("/e-commerce/nouveau", name="products.new")
     */
    public function addProduct(Request $request, FileUploader $fileUploader): Response
    {
        $em = $this->doctrine->getManager();
        $product = new Articles();
        $sku = $request->get("sku");
        if ($sku) $product = $em->getRepository(Articles::class)->findOneBySku($sku);
        $marques = $em->getRepository(Marques::class)->findAll();
        $types = $em->getRepository(Parametres::class)->findByType('Types');
        $categories = $em->getRepository(Parametres::class)->findByType('Categories');

        if ($request->isMethod('POST')) {
            $type = $request->get('type');
            $photo = $request->files->get('photo');
            $libelle = $request->get('libelle');
            $description = $request->get('description') ?? "";

            $param->setLibelle($libelle)
                ->setType($type)
                ->setDescription($description)
                ->updatedUserstamps($this->getUser());
            ;
            $param->updatedTimestamps();
            if ($photo) {
                $image = new Files();
                if ($param->getImage()) $image = $em->getRepository(Files::class)->find($param->getImage());
                $fileName = $fileUploader->upload($photo);
                $image->setTempFile($fileName)->setAlt($libelle);
                $em->persist($image);
                $param->setImage($image);
            }
            $em->persist($param);
            $em->flush();
            return $this->redirectToRoute('admins.list');
        }
        return $this->render('backend/e-commerce/new.html.twig', [
            'product' => $product,
            'types' => $types,
            'marques' => $marques,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/e-commerce/delete", name="products.delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteProduct(Request $request)
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