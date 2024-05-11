<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivreCardController extends AbstractController
{
    #[Route('/livre/card', name: 'app_livre_card')]
    public function index(LivreRepository $livreRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Retrieve all livres (or apply filters/sorting if needed)
        $livres = $livreRepository->findAll();
    
        // Use Paginator to paginate the livres
        $pagination = $paginator->paginate(
            $livres,  // Query results (array of Livre objects)
            $request->query->getInt('page', 1), // Current page from query parameter (default 1)
            5      // Items per page (adjust as needed)
        );
        return $this->render('livre_card/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}