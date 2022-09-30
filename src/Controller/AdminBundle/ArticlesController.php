<?php

namespace App\Controller\AdminBundle;

use App\Entity\Articles;
use App\Entity\Marques;
use App\Entity\Parametres;
use App\Entity\Variantes;
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
    public function listProducts(Request $request, Session $session): Response
    {
        $session->set('menu', 'e-commerce');
        $listProduct = $this->doctrine->getRepository(Articles::class)->findAll();
        return $this->render('backend/e-commerce/list.html.twig', [
            'produits' => $listProduct
        ]);
    }

    /**
     * @Route("/e-commerce/produit", name="products.new")
     */
    public function addProduct(Request $request, Session $session, FileUploader $fileUploader): Response
    {
        $session->set('menu', 'e-commerce');
        $em = $this->doctrine->getManager();
        $product = new Articles();
        $modif = $request->get("modif");
        if ($modif) $product = $em->getRepository(Articles::class)->find($modif);
        $marques = $em->getRepository(Marques::class)->findAll();
        $types = $em->getRepository(Parametres::class)->findByType('Types');
        $categories = $em->getRepository(Parametres::class)->findByType('Categories');

        if ($request->isMethod('POST')) {
            $cover = $request->files->get('cover');
            $status = $request->get('status');
            $categorie = $em->getRepository(Parametres::class)->find($request->get('categorie'));
            $type = $em->getRepository(Parametres::class)->find($request->get('type'));
            $tags = json_decode($request->get('tags'));
            $marque = $em->getRepository(Marques::class)->find($request->get('marque'));
            $product_name = $request->get('product_name');
            $description = $request->get('description') ?? "";
            $price = (int) $request->get('price');
            $remise = $request->get('remise');
            $valeur_remise = (int) $request->get('valeur_remise');
            $sku = $request->get('sku');
            $quantite = (int) $request->get('quantite');
            $stock = (int) $request->get('stock');
            $variantes = $request->get('variantes') ?? [];
            $backorders = $request->get('backorders') ?? false;
            $weight = $request->get('weight');
            $width = $request->get('width');
            $height = $request->get('height');
            $length = $request->get('length');
            $array_tags = [];
            // dd($request);

            foreach ($tags as $item) array_push($array_tags, $item->value);
            foreach ($variantes as $value) {
                $variante = new Variantes();
                $variante->setType($value['option'])->setValeur($value['value'])->updatedUserstamps($this->getUser());
                $variante->updatedTimestamps();
                $em->persist($variante);
                $product->addVariante($variante);
            }

            $product->setNom($product_name)
                ->setStatus($status)
                ->setCategorie($categorie)
                ->setType($type)
                ->setTags($array_tags)
                ->setMarque($marque)
                ->setPoints($price)
                ->setRemise($remise)
                ->setValeurRemise($valeur_remise)
                ->setSku($sku)
                ->setQuantite($quantite)
                ->setStock($stock)
                ->setBackorders($backorders)
                ->setPoids($weight)
                ->setLargeur($width)
                ->setHauteur($height)
                ->setLongueur($length)
                ->setDescription($description)
                ->updatedUserstamps($this->getUser());
            ;
            $product->updatedTimestamps();
            if ($cover) {
                $image = new Files();
                if ($product->getCover()) $image = $em->getRepository(Files::class)->find($product->getCover());
                $fileName = $fileUploader->upload($photo);
                $image->setTempFile($fileName)->setAlt($nom)->setType('Articles');
                $em->persist($image);
                $product->setCover($image);
            }
            $em->persist($product);
            // dd($product);
            $em->flush();
            return $this->redirectToRoute('products.list');
        }
        return $this->render('backend/e-commerce/new.html.twig', [
            'product' => $product,
            'types' => $types,
            'marques' => $marques,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/e-commerce/produit-{id}/add-medias", name="products.medias")
     */
    public function addMedias(Request $request, Articles $article, FileUploader $fileUploader): Response
    {
        $em = $this->doctrine->getManager();
        $medias = $em->getRepository(Files::class)->findAll();
        if ($request->isXmlHttpRequest()) {
            $file = $request->files->get('media');
            $media = new Files();
            $fileName = $fileUploader->upload($file);
            $media->setTempFile($fileName)
                ->setType('Medias')
                ->setArticle($article)
                ->setAlt($file->getClientOriginalName())
                ->updatedUserstamps($this->getUser());
            $media->updatedTimestamps();

            // foreach ($medias as $value) {
            //     if (in_array($value->getAlt(), $remove_files)) 
            // }
            
            $em->persist($media);
            // $em->flush();
        }
        return new JsonResponse($media->getId(), 200);
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