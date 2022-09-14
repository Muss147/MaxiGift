<?php

namespace App\Controller\AdminBundle;

use App\Entity\Sondages;
use App\Entity\Enquetes;
use App\Entity\Entreprises;
use App\Entity\Questions;
use App\Entity\Reponses;
use App\Entity\Conditions;
use App\Entity\Ciblages;
use App\Entity\Locations;
use App\Entity\EnquetesCibles;
use App\Entity\Parametres;
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
class SondagesController extends AbstractController
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
     * @Route("/sondages-list", name="sondages.list")
     */
    public function listSondages(Session $session): Response
    {
        $session->set('menu', 'sondage');
        $em = $this->doctrine->getManager();
        $sondages = $em->getRepository(Sondages::class)->findAll();
        return $this->render('backend/sondages/list.html.twig', [
            'sondages' => $sondages,
        ]);
    }

    /**
     * @Route("/sondages/create", name="sondages.create")
     */
    public function createSondages(Request $request, Session $session, SluggerInterface $slugger, FileUploader $fileUploader): Response
    {
        $session->set('menu', 'sondage');
        $em = $this->doctrine->getManager();
        $id = $request->get('id');
        $sondage = new Sondages();
        if ($id) $sondage = $em->getRepository(Sondages::class)->find($id);
        $entreprises = $em->getRepository(Entreprises::class)->findAll();
        $enquetes = $em->getRepository(Enquetes::class)->findAll();
        $questions = $em->getRepository(Questions::class)->findByEnquete(null);
        $reponses = $em->getRepository(Reponses::class)->findAll();

        if ($request->isMethod('POST')) {
            $nom = $request->get('nom');
            $points = $request->get('points');
            $entreprise = $em->getRepository(Entreprises::class)->find($request->get('entreprise')) ?? null;
            $publish = $request->get('publish');
            $paramEnvoi = $request->get('paramEnvoi') ?? [];
            $questions = $request->get('questions') ?? [];
            $conditions = $request->get('conditions') ?? [];
            $description = $request->get('description');
            $file = $request->files->get('cover');

            // start: Ciblage
            $ciblage = $sondage->getCiblage() ?? new Ciblages();
            $sexeCible = $request->get('sexeCible') ?? [];
            $metierCible = $request->get('metierCible') ?? [];
            $adressCible = $request->get('adressCible') ?? [];
            $cibles = $request->get('cibles') ?? [];
            $ageMini = $request->get('ageMini');
            $ageMaxi = $request->get('ageMaxi');
            $lastCmd = $request->get('lastCmd');
            foreach ($adressCible as $key => $adress) {
                $adressId = $adress['id'] ?? null;
                $location = new Locations();
                if ($adressId) $location = $em->getRepository(Locations::class)->find($adressId);
                $location->setAdresse($adress['adresse'])
                    ->setCommune($adress['sublocality'])
                    ->setVille($adress['locality'])
                    ->setPays($adress['country'])
                    ->updatedUserstamps($this->getUser());
                $location->updatedTimestamps();
                $em->persist($location);
                $ciblage->addLocation($location);
            }
            foreach ($cibles as $key => $value) {
                $cibleId = $value['id'] ?? null;
                $enquete = $value['enquete'] ?? null;
                $question = $value['question'] ?? null;
                $reponses = $value['reponses'] ?? [];
                $cible = new EnquetesCibles();
                if ($cibleId) $cible = $em->getRepository(EnquetesCibles::class)->find($cibleId);
                $cible->setEnquete($em->getRepository(Enquetes::class)->find($enquete))
                    ->setQuestion($em->getRepository(Questions::class)->find($question))
                    ->updatedUserstamps($this->getUser());
                $cible->updatedTimestamps();
                foreach ($reponses as $reponse) $cible->addReponse($em->getRepository(Reponses::class)->find($reponse));
                $em->persist($cible);
                $ciblage->addCible($cible);
            }
            $ciblage->setSexe($sexeCible)
                ->setCategoriesSP($metierCible)
                ->setAgeMini($ageMini)
                ->setAgeMaxi($ageMaxi)
                ->setLastCmd($lastCmd)
                ->updatedUserstamps($this->getUser());
            $ciblage->updatedTimestamps();
            $em->persist($ciblage);
            $sondage->setCiblage($ciblage);
            // end: Ciblage
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
                    $sondage->addCondition($condition);
                }
            }
            if (isset($publish)) {
                if ($request->get('publish')) $sondage->setStatus(false);
                else $sondage->setStatus(true);
            }
            $sondage->setTitre($nom)
                ->setSlug($slugger->slug($nom))
                ->setPoints($points)
                ->setEntreprise($entreprise)
                ->setParamEnvoi($paramEnvoi)
                ->setDescription($description)
                ->updatedUserstamps($this->getUser());
            $sondage->updatedTimestamps();
            if ($file) {
                $image = new Files();
                if ($sondage->getCover()) $image = $em->getRepository(Files::class)->find($sondage->getCover()->getId());
                $fileName = $fileUploader->upload($file);
                $image->setTempFile($fileName)->setAlt($nom);
                $em->persist($image);
                $sondage->setCover($image);
            }
            $em->persist($sondage);
            $em->flush();
            if (isset($publish)) return $this->redirectToRoute('sondages.list');
        }
        return $this->render('backend/sondages/create.html.twig', [
            'sondage' => $sondage,
            'entreprises' => $entreprises,
            'enquetes' => $enquetes,
            'questions' => $questions,
            'reponses' => $reponses,
        ]);
    }

    /**
     * @Route("/sondages/delete-{id}", name="sondages.delete")
     * @param Sondages $sondage
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteSondage(Sondages $sondage, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($sondage);
        $em->flush();
        return $this->redirectToRoute('sondages.list');
    }
}