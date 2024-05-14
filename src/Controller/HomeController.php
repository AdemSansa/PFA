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
    
        $livres = $livreRepository->findAll();
    
   
        $pagination = $paginator->paginate(
            $livres, 
            $request->query->getInt('page', 1), 
            6      
        );
        
        return $this->render('home/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
