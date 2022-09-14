<?php

namespace App\Controller\AdminBundle;

use App\Entity\Enquetes;
use App\Entity\Sondages;
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
use Twig\Environment;

/**
 * @Route("/backend", requirements={"_locale": "en|es|fr"})
 */
class QuestionsController extends AbstractController
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
     * @Route("/question/create", name="question.create")
     */
    public function createQuestion(Request $request): Response
    {
        $em = $this->doctrine->getManager();
        $return = [];
        $return['reponses'] = [];
        $idModel = $request->get('idModel');
        if ($request->get('modele') == "enquete") {
            $modele = new Enquetes();
            if ($idModel) $modele = $em->getRepository(Enquetes::class)->find($idModel);
        }
        elseif ($request->get('modele') == "sondage") {
            $modele = new Sondages();
            if ($idModel) $modele = $em->getRepository(Sondages::class)->find($idModel);
        }

        if ($request->isMethod('POST')) {
            $id = $request->get('idQuestion');
            $question = new Questions();
            if ($id) $question = $em->getRepository(Questions::class)->find($id);

            $libelle = $request->get('libelle');
            $description = $request->get('description');
            $reponses = $request->get('reponses') ?? [];
            $reponsesId = $request->get('reponsesId') ?? [];
            $numero = $request->get('numero');
            $type = $request->get('type');
            $required = $request->get('required') ?? false;

            $question->setLibelle($libelle)
                ->setDescription($description)
                ->setNumero($numero)
                ->setRequired($required)
                ->setType($type)
                ->updatedUserstamps($this->getUser());
            $question->updatedTimestamps();
            if ($request->get('modele') == "enquete") $question->setEnquete($modele);
            else $question->setSondage($modele);
            
            if ($type == 'Choix Multiple' || $type == 'Choix Unique' || ($type == 'Oui / Non' && $id == null)) {
                foreach ($reponses as $key => $value) {
                    $reponse = $em->getRepository(Reponses::class)->find($reponsesId[$key] ?? 0);
                    if (!$reponse) $reponse = new Reponses();
                    $reponse->setLibelle($value)->updatedUserstamps($this->getUser());
                    $reponse->updatedTimestamps();
                    $em->persist($reponse);
                    $question->addReponse($reponse);

                    array_push($return['reponses'], $value);
                }
            }
            $em->persist($modele);
            $em->persist($question);
            $em->flush();

            $return['id'] = $question->getId();
            $return['modele'] = $modele->getId();
            $return['libelle'] = $libelle;
            $return['numero'] = $numero;
            $return['required'] = $required;
            $return['type'] = $type;
        }
        return new JsonResponse($return, 200);
    }

    /**
     * @Route("/question/search-{id}", name="question.search")
     */
    public function searchQuestion(Questions $question): Response
    {
        $return['id'] = $question->getId();
        $return['type'] = $question->getType();
        $return['libelle'] = $question->getLibelle();
        $return['description'] = $question->getDescription();
        $return['numero'] = $question->getNumero();
        $return['required'] = $question->isRequired();
        $return['reponses'] = [];
        foreach($question->getReponses() as $reponse) {
            $temp['id'] = $reponse->getId();
            $temp['libelle'] = $reponse->getLibelle();
            array_push($return['reponses'], $temp);
        }
        return new JsonResponse($return, 200);
    }

    /**
     * @Route("/reponse/delete-{id}", name="reponse.delete")
     * @param Reponses $reponse
     */
    public function deleteReponse(Reponses $reponse, Request $request)
    {
        $em = $this->doctrine->getManager();
        $em->remove($reponse);
        $em->flush();
        return new JsonResponse(true, 200);
    }

    /**
     * @Route("/question/delete-{id}", name="question.delete")
     * @param Questions $question
     */
    public function deleteQuestion(Questions $question, Request $request)
    {
        $em = $this->doctrine->getManager();
        $em->remove($question);
        $em->flush();
        return new JsonResponse(true, 200);
    }

}