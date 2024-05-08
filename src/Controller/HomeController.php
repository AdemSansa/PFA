<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(LivreRepository $rep ): Response
    {
        $livres = $rep->findAll(); 
        
        return $this->render('home/index.html.twig', [
            'livres' => $livres,
        ]);
    }
}
