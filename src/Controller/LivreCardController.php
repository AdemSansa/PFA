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
        $searchTerm = $request->get('q'); 
        $livres = $livreRepository->findBySearchTerm($searchTerm);
        if (empty($livre)) {
            $livres = $livreRepository->findAll();
        }



        
    
  
        $pagination = $paginator->paginate(
            $livres,  
            $request->query->getInt('page', 1), 
            5      
        );
        return $this->render('livre_card/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}