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

    public function __construct(Environment $twig) {
        $this->twig = $twig;
    }

    /**
     * @Route("/parametre/{type}/list", name="param.list")
     */
    public function listParam(Request $request, $type): Response
    {
        $listParams = $this->getDoctrine()->getRepository(Parametres::class)->findByType($type);
        // dump($listUsers); die();
        return $this->render('admin/parametre/list.html.twig', [
            'type' => $type,
            'parametres' => $listParams
        ]);
    }

    /**
     * @Route("/parametre/find-{id}", name="param.find")
     */
    public function findParam(Request $request, $id): Response
    {
        $result = $this->getDoctrine()->getRepository(Parametres::class)->find($id);
        $param['id'] = $result->getId();
        $param['libelle'] = $result->getLibelle();
        $param['desc'] = $result->getDescription();
        if ($result->getImage()) $param['image'] = $result->getImage()->getTempFile();
        else $param['image'] = "defaultIcon.png";

        return new JsonResponse($param, 200);
    }

    /**
     * @Route("/parametre/new", name="param.new")
     * @var \App\Entity\User $user
     */
    public function newParam(Request $request, FileUploader $fileUploader): Response
    {
        $em = $this->getDoctrine()->getManager();
        // dump($request); die();
        $type = $request->get("type");

        if ($request->isMethod('POST')) {
            for ($i=0; $i < count($request->get("libelle")); $i++) { 

                $libelle = $request->get("libelle")[$i];
                $desc = $request->get("desc")[$i];

                if (empty($libelle)) {
                    echo "Veuillez renseigner le libellé N°".$i; die();
                }

                $param = new Parametres();
                $param->setLibelle($libelle)
                    ->setType($type)
                    ->setDescription($desc)
                    ->updatedUserstamps($this->getUser());
                ;
                $param->updatedTimestamps();
                if (isset($request->files->get('photo')[$i])) {
                    $photo = $request->files->get('photo')[$i];
                    $image = new Files();
                    $fileName = $fileUploader->upload($photo);
                    $image->setTempFile($fileName)->setAlt($libelle);
                    $em->persist($image);
                    $param->setImage($image);
                }
                $em->persist($param);
                $em->flush();
            }
            
            return $this->redirectToRoute('param.list', [
                "type" => $type
            ]);
        }
        return $this->render('admin/parametre/add.html.twig', [
            "type" => $type
        ]);
        
    }

    /**
     * @Route("/param/edit", name="param.edit")
     */
    public function editParam(Request $request, FileUploader $fileUploader): Response
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $param = $em->getRepository(':Parametre')->find($request->get("id"));
            if($param) {
                $libelle = $request->get("libelle");
                $type = $request->get("type");
                $desc = $request->get("desc");
                $photo = $request->files->get('photo');

                if (empty($libelle)) {
                    echo "Veuillez renseigner le libellé"; die();
                }
                
                $param->setLibelle($libelle)
                    ->setDescription($desc)
                    ->updatedUserstamps($this->getUser());
                ;
                $param->updatedTimestamps();
                if ($photo) {
                    if($param->getImage()->getId()) {
                        $image = $em->getRepository(Files::class)->find($param->getImage()->getId());
                    }
                    else $image = new Files();
                    /** @var UploadedFile $photo */
                    $fileName = $fileUploader->upload($photo);
                    $image->setTempFile($fileName)->setAlt($libelle);
                    $em->persist($image);
                    $param->setImage($image);
                }
                $em->persist($param);
                $em->flush();
            }
            // else echo "Identifiant incorrect"; die(); 
        }
        
        return $this->redirectToRoute('param.list', [
            "type" => $type
        ]);
        
    }

    /**
     * @Route("/parametre/delete-{id}", name="param.delete", methods="DELETE")
     * @param Parametres $param
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteParam(Parametres $param, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->isCsrfTokenValid('delete'.$param->getId(), $request->get('_token'))) {
            $em->remove($param);
            $em->flush();
        }
        return $this->redirectToRoute('param.list', [
            "type" => $request->get('type')
        ]);
    }


}