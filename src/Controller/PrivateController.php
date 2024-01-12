<?php

namespace App\Controller;

use App\Repository\TestRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrivateController extends AbstractController
{
    #[Route('/private', name: 'app_private')]
    public function private (TestRepository $testRepository): Response
    {
        $user = $this->getUser();
        if ($user->getRoles = ["ROLE_USER", "ROLE_ADMIN"]) {
            return $this->render('private/index.html.twig', [
                'controller_name' => 'PrivateController',
            ]);
        }
        $this->redirectToRoute('app.homepage');
    }
}