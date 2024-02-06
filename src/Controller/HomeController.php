<?php
namespace App\Controller;

use App\Repository\TestRepository;
use App\Service\apiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('', name: 'app.homepage')]
    public function index(TestRepository $testRepository): Response
    {
        $user = $this->getUser();
        return $this->render('Frontend/Home/index.html.twig', ['user' => $user, 'commentaires' => $testRepository->findAll()]);
    }
}