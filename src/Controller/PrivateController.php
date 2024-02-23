<?php

namespace App\Controller;

use App\Entity\Flag;
use App\Repository\FlagRepository;
use App\Repository\TestRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
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
    public function private (TestRepository $testRepository, FlagRepository $flagRepository): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $flag = $flagRepository->findOneById(9239874);
            return $this->render('private/index.html.twig', [
                'controller_name' => 'PrivateController',
                'flag' => $flag
            ]);
        }
        return $this->redirectToRoute('app.homepage');
    }

    // #[Route('/private/flag', name: 'app_private_flag', methods: ['GET', 'POST'])]
    // public function flague(Request $request, FlagRepository $flagRepository): Response
    // {
    //     $id = $request->request->get('id');
    //     if ($id !== null && ctype_digit($id) && intval($id) >= 0) {
    //         $flag = $flagRepository->findOneById($id);
    //         return $this->render('private/index.html.twig', [
    //             'controller_name' => 'PrivateController',
    //             'flag' => $flag
    //         ]);
    //     }
    //     return $this->redirectToRoute('logout');
    // }
}