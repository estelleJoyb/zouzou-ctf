<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\TestType;
use App\Service\apiService;
use App\Repository\TestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('', name: 'app.test')]
class TestController extends AbstractController
{
    public function __construct(private TestRepository $testRepository, private EntityManagerInterface $em)
    {
    }

    #[Route('/test', name: '.index', methods: ['GET'])]
    public function index(TestRepository $testRepository, apiService $apiService): Response
    {
        $commentaires = $testRepository->findAll();
        $cuteWords = array();
        foreach ($commentaires as $commentaire) {
            array_push($cuteWords, $apiService->getCuteMessages());
        }

        return $this->render('Frontend/Test/test.html.twig', [
            'commentaires' => $commentaires,
            'cutewords' => $cuteWords
        ]);
    }

    #[Route('/new', name: '.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response|RedirectResponse
    {
        $test = new Test();
        //recover the form used for create a commentaire (test)
        //it updates the variable test
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request); //inspect the given request → check if the form has been submit

        if ($form->isSubmitted() && $form->isValid()) {
            $test->setIp($request->getClientIp());
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                // $safeFilename = $imageFile->slug($originalFilename);

                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where images are stored

                try {
                    $imageFile->move(
                        $this->getParameter('images'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $test->setImage($newFilename);
            }

            $this->em->persist($test); //save in the database
            $em->flush();
            $this->addFlash('success', 'Commentaire créé avec succès !'); //user feedback
            return $this->redirectToRoute('app.homepage');
        }


        return $this->render('Frontend/Test/new.html.twig', [
            'commentaire' => $test,
            'form' => $form,
        ]);
    }
}