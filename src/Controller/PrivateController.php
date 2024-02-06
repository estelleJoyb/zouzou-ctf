<?php

namespace App\Controller;

use App\Repository\TestRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrivateController extends AbstractController
{
    public function __construct(
        private Security $security,
        private RequestStack $requestStack
    ) {
    }

    #[Route('/private', name: 'app_private')]
    public function private (TestRepository $testRepository): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $firewallName = $this->security->getFirewallConfig($request)?->getName();
        $user = $this->getUser();
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->render('private/index.html.twig', [
                'controller_name' => 'PrivateController',
            ]);
        }
        $this->redirectToRoute('app.homepage');
    }
}