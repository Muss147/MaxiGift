<?php
namespace App\Controller;

use App\AdminBundle\Entity\Slider;
use App\AdminBundle\Entity\Newsletter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Environment;

class FrontController extends AbstractController
{
	/**
	 * @Route("/", name="home")
	 */
	public function index(): Response
	{
		return $this->render('pages/home.html.twig');
	}

}


?>