<?php

namespace App\Controller\AdminBundle;

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
class ParametresController extends AbstractController
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
     * @Route("/parametres/liste-{type}", name="param.list")
     */
    public function listParam(Request $request, $type): Response
    {
        $listParams = $this->doctrine->getRepository(Parametres::class)->findByType($type);
        return $this->render('backend/parametres/list.html.twig', [
            'type' => $type,
            'parametres' => $listParams
        ]);
    }

    /**
     * @Route("/parametres/add", name="param.add")
     */
    public function addParam(Request $request, FileUploader $fileUploader): Response
    {
        $em = $this->doctrine->getManager();
        $param = new Parametres();
        $id = $request->get("id");
        if ($id) $param = $em->getRepository(Parametres::class)->find($id);

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
        
        if ($request->isXmlHttpRequest()) {
            $params = [];
            $listParams = $em->getRepository(Parametres::class)->findByType($type);
            foreach ($listParams as $value) {
                $temp['id'] = $value->getId();
                $temp['photo'] = $photo;
                if ($value->getImage()) $temp['photo'] = $value->getImage()->getTempFile();
                $temp['libelle'] = $value->getLibelle();
                array_push($params, $temp);
            }
            return new JsonResponse($params, 200);
        }
        else return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/parametres/delete", name="param.delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteParams(Request $request)
    {
        $em = $this->doctrine->getManager();
        foreach ($request->get('paramsDeleted') as $value) {
            $param = $em->getRepository(Parametres::class)->find($value);
            $em->remove($param);
        }
        $em->flush();
        return $this->redirect($request->headers->get('referer'));
    }
}