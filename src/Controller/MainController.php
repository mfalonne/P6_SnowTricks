<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'trick.home')]
    public function index(Request $request, TrickRepository $repository): Response
    {
        $tricks = $repository -> findAll();
    
        return $this->render('main/index.html.twig', [
            'tricks' => $tricks
        ]);
    }

    #[Route('/trick/{slug}-{id}', name: 'trick.show', requirements: ['id' => '\d+'])]
    public function show(Request $request , string $slug, int $id, TrickRepository $repository): Response
    {
        $trick = $repository -> find($id);

        if ($trick->getSlug() !== $slug) {

            return $this->redirectToRoute('trick.show', ['slug'=> $trick->getSlug(), 'id' => $trick->getId()]);
        }

        return $this->render('main/show.html.twig', [
            'trick' => $trick
        ]);
    }
}
