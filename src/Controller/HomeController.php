<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(LivreRepository $livreRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Retrieve all livres (or apply filters/sorting if needed)
        $livres = $livreRepository->findAll();
    
        // Use Paginator to paginate the livres
        $pagination = $paginator->paginate(
            $livres,  // Query results (array of Livre objects)
            $request->query->getInt('page', 1), // Current page from query parameter (default 1)
            6      // Items per page (adjust as needed)
        );
        
        return $this->render('home/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
