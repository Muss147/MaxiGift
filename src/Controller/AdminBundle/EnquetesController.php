<?php

namespace App\Controller\AdminBundle;

use App\Entity\Enquetes;
use App\Entity\Questions;
use App\Entity\Reponses;
use App\Entity\Conditions;
use App\Entity\Files;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Environment;

/**
 * @Route("/backend", requirements={"_locale": "en|es|fr"})
 */
class EnquetesController extends AbstractController
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
     * @Route("/enquetes-list", name="enquetes.list")
     */
    public function listEnquetes(Session $session): Response
    {
        $session->set('menu', 'enquete');
        $em = $this->doctrine->getManager();
        $enquetes = $em->getRepository(Enquetes::class)->findAll();
        return $this->render('backend/enquetes/list.html.twig', [
            'enquetes' => $enquetes,
        ]);
    }

    /**
     * @Route("/enquetes/create", name="enquetes.create")
     */
    public function createEnquetes(Request $request, Session $session, SluggerInterface $slugger, FileUploader $fileUploader): Response
    {
        $session->set('menu', 'enquete');
        $em = $this->doctrine->getManager();
        $id = $request->get('id');
        $enquete = new Enquetes();
        if ($id) $enquete = $em->getRepository(Enquetes::class)->find($id);

        if ($request->isMethod('POST')) {
            $nom = $request->get('nom');
            $points = $request->get('points');
            $publish = $request->get('publish');
            $questions = $request->get('questions') ?? [];
            $conditions = $request->get('conditions') ?? [];
            $description = $request->get('description');
            $file = $request->files->get('cover');

            foreach ($questions as $key => $value) {
                $question = $em->getRepository(Questions::class)->find($value);
                $question->setNumero($key+1)->updatedUserstamps($this->getUser());
                $question->updatedTimestamps();
                $em->persist($question);
            }
            foreach ($conditions as $key => $value) {
                if ($value['return']) {
                    $condId = $value['id'] ?? null;
                    $condition = new Conditions();
                    if ($condId) $condition = $em->getRepository(Conditions::class)->find($condId);
                    $condition->setQuestion($em->getRepository(Questions::class)->find($value['question']))
                        ->setReponse($em->getRepository(Reponses::class)->find($value['reponse']))
                        ->setRedirection($em->getRepository(Questions::class)->find($value['return']))
                        ->updatedUserstamps($this->getUser());
                    $condition->updatedTimestamps();
                    $em->persist($condition);
                    $enquete->addCondition($condition);
                }
            }
            if (isset($publish)) {
                if ($request->get('publish')) $enquete->setStatus(false);
                else $enquete->setStatus(true);
            }
            $enquete->setNom($nom)
                ->setSlug($slugger->slug($nom))
                ->setPoints($points)
                ->setDescription($description)
                ->updatedUserstamps($this->getUser());
            $enquete->updatedTimestamps();
            if ($file) {
                $image = new Files();
                if ($enquete->getCover()) $image = $em->getRepository(Files::class)->find($enquete->getCover()->getId());
                $fileName = $fileUploader->upload($file);
                $image->setTempFile($fileName)->setAlt($nom);
                $em->persist($image);
                $enquete->setCover($image);
            }
            $em->persist($enquete);
            $em->flush();
            if (isset($publish)) return $this->redirectToRoute('enquetes.list');
        }
        return $this->render('backend/enquetes/create.html.twig', [
            'enquete' => $enquete
        ]);
    }

    /**
     * @Route("/condition/delete-{id}", name="condition.delete")
     * @param Conditions $condition
     */
    public function deleteCondition(Conditions $condition, Request $request)
    {
        $em = $this->doctrine->getManager();
        $em->remove($condition);
        $em->flush();
        return new JsonResponse(true, 200);
    }

    /**
     * @Route("/enquetes/delete-{id}", name="enquetes.delete")
     * @param Enquetes $enquete
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteEnquete(Enquetes $enquete, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($enquete);
        $em->flush();
        return $this->redirectToRoute('enquetes.list');
    }
}